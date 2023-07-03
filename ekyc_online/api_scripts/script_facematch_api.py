from pathlib import Path
from urllib.parse import urlparse
from urllib.parse import urljoin
from urllib.request import pathname2url
import urllib
import urllib.request
import requests
import json
import sys
from PIL import Image
from io import BytesIO
from matplotlib import patches
import matplotlib.pyplot as plt


subscription_key = '6cdd85dee1ae4631ba68575a84705213'

def annotate_image(image_url, subscription_key, api_url, show_face_id=False):
    """ Helper function for Microsoft Azure face detector.

    Args:
        image_url: Can be a remote http://  or file:// url pointing to an image less then 10MB
        subscription_key: Cognitive services generated key
        api_url: API end point from Cognitive services
        show_face_id: If True, display the first 6 characters of the faceID

    Returns:
        figure: matplotlib figure that contains the image and boxes around the faces with their age and gender
        json response: Full json data returned from the API call

    """

    # The default header must include the sunbscription key
    headers = {'Ocp-Apim-Subscription-Key': subscription_key}

    params = {
        'returnFaceId': 'true',
        'returnFaceLandmarks': 'false',
        'returnFaceAttributes': 'age,gender,headPose,smile,facialHair,glasses,emotion,hair,makeup,occlusion,accessories,blur,exposure,noise',
    }

    # Figure out if this is a local file or url
    parsed_url =urlparse(image_url)
    if parsed_url.scheme == 'file':
        mod_url= parsed_url.path[1:]
        image_data = open(mod_url, "rb").read()

        # When making the request, we need to add a Content-Type Header
        # and pass data instead of a url
        headers['Content-Type']='application/octet-stream'
        response = requests.post(api_url, params=params, headers=headers, data=image_data)

        # Open up the image for plotting
        image = Image.open(mod_url)
    else:
        # Pass in the URL to the API
        response = requests.post(api_url, params=params, headers=headers, json={"url": image_url})
        image_file = BytesIO(requests.get(image_url).content)
        image = Image.open(image_file)

    faces = response.json()

    fig, ax = plt.subplots(figsize=(10,10))

    ax.imshow(image, alpha=0.6)
    for face in faces:
        fr = face["faceRectangle"]
        fa = face["faceAttributes"]
        origin = (fr["left"], fr["top"])
        p = patches.Rectangle(origin, fr["width"],
                            fr["height"], fill=False, linewidth=2, color='b')
        ax.axes.add_patch(p)
        ax.text(origin[0], origin[1], "%s, %d"%(fa["gender"].capitalize(), fa["age"]),
                fontsize=16, weight="bold", va="bottom")

        if show_face_id:
            ax.text(origin[0], origin[1]+fr["height"], "%s"%(face["faceId"][:5]),
            fontsize=12, va="bottom")
    ax.axis("off")

    # Explicitly closing image so it does not show in the notebook
    plt.close()
    return fig, faces

def face_compare(id_1, id_2, api_url):
    """ Determine if two faceIDs are for the same person
    Args:
        id_1: faceID for person 1
        id_2: faceID for person 2
        api_url: API end point from Cognitive services
        show_face_id: If True, display the first 6 characters of the faceID

    Returns:
        json response: Full json data returned from the API call

    """
    headers = {
        'Content-Type': 'application/json',
        'Ocp-Apim-Subscription-Key': subscription_key
    }

    body = {"faceId1": id_1, "faceId2": id_2}

    params = {}
    response = requests.post(api_url,
                            params=params,
                            headers=headers,
                            json=body)
    return response.json()

image1='file:///'+sys.argv[1]
image2='file:///'+sys.argv[2]
verifyface_api_url='https://eastus.api.cognitive.microsoft.com/face/v1.0/verify'
face_api_url = 'https://eastus.api.cognitive.microsoft.com/face/v1.0/detect'
labeled_image, response_1 = annotate_image(image1,subscription_key,face_api_url,show_face_id=True)
labeled_image, response_2 = annotate_image(image2,subscription_key,face_api_url,show_face_id=True)

verify_response=face_compare(response_2[0]['faceId'], response_1[0]['faceId'], verifyface_api_url)

print(verify_response['confidence'])
