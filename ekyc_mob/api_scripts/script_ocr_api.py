from azure.cognitiveservices.vision.computervision import ComputerVisionClient
from azure.cognitiveservices.vision.computervision.models import OperationStatusCodes
from azure.cognitiveservices.vision.computervision.models import VisualFeatureTypes
from msrest.authentication import CognitiveServicesCredentials
import requests
import base64
import json
import time
import re
import sys
from PIL import Image
from io import BytesIO


api_key = 'f3fc4eea066c4df5a21ae15032e9e3d9'
api_url='https://ocrdbh.cognitiveservices.azure.com/'
image_url=sys.argv[1]

#d3e6b46a40144a34b238ad7db634126c   f3fc4eea066c4df5a21ae15032e9e3d9 03fa8b62420649e4870d572993261a20
computervision_client = ComputerVisionClient(api_url, CognitiveServicesCredentials(api_key))
img = open(image_url, "rb")
recognize_handwriting_results = computervision_client.read_in_stream(img,raw=True)
operation_location_local = recognize_handwriting_results.headers["Operation-Location"]
operation_id = operation_location_local.split("/")[-1]
while True:
    get_handw_text_results = computervision_client.get_read_result(operation_id)
    if get_handw_text_results.status not in ['notStarted', 'running']:
        break
    time.sleep(1)
str=""
finalstr=""
# Print the detected text, line by line
if get_handw_text_results.status == OperationStatusCodes.succeeded:
    for text_result in get_handw_text_results.analyze_result.read_results:
        for line in text_result.lines:
            str=str+line.text+"-"
            
if re.search('\d\d\d \d\d\d \d\d\d\d',str):
    nid=re.findall(r'\d\d\d \d\d\d \d\d\d\d',str)
    nid=nid[0]
    nid=nid.lstrip()
elif  re.search('\d{10}\d{13}|\d{17}',str):
    nid=re.findall(r'\d{10}\d{13}|\d{17}',str)
    nid=nid[0]
    nid=nid.lstrip()
elif re.search(r'ID NO:.*-',str):
    nid= re.findall(r'-ID NO:.*-',str)
    start=nid[0].find('ID NO:')+6
    end=nid[0].find('-',start)
    nid=nid[0][start:end]
    nid=nid.lstrip()
else:
    nid=""

if re.search(r'Name-.*-',str):
    name= re.findall(r'-Name-.*-',str)
    start=name[0].find('Name-')+5
    end=name[0].find('-',start)
    name=name[0][start:end]
    name=name.lstrip()
elif re.search(r'Name:.*-',str):
    name= re.findall(r'Name:.*-',str)
    start=name[0].find('Name:')+5
    end=name[0].find('-',start)
    name=name[0][start:end]
    name=name.lstrip()
else:
    name=''

dob=re.findall(r'\d\d \w\w\w \d\d\d\d',str)
dob=dob[0]
dob=dob.lstrip()

user_data={'Name':name,'Nid':nid,'Dob':dob}

print (json.dumps(user_data))
