import sys
import requests
import base64
import json
from PIL import Image
from io import BytesIO

api_key = '7636cdeb-88e7-4d23-9a17-1dfc8e4ba889'
api_url='https://api.porichoybd.com/api/v0/Kyc/nid-person-values-image-match'
image=sys.argv[1]
nid=sys.argv[2]
dob=sys.argv[3]
image_file=open(image,"rb")
encoded_img=base64.b64encode(image_file.read())
base64_img=str(encoded_img.decode('utf-8'))
headers = {
    'Content-Type': 'application/json',
    'x-api-key': api_key
}

body = {"person_photo": base64_img, "national_id": nid,'person_dob':dob,"english_output":True}
params={}
response = requests.post(api_url,
                        params=params,
                        headers=headers,
                        json=body)
output=response.json()
result=output['voter']['faceMatchResult']['percentage']
match=output['voter']['faceMatchResult']['matched']
name=output['voter']['nameEn']
dob=output['voter']['dob']
fname=output['voter']['fatherEn']
mname=output['voter']['motherEn']
sname=output['voter']['spouseEn']
paddress=output['voter']['permanentAddressEn']
praddress=output['voter']['presentAddressEn']
nidimg=output['voter']['photo']
ekyc_stat=output['passKyc']
user_data={'Result':match,'Percentage':result,'Name':name,'Dob':dob,'FName':fname,'MName':mname,'Spouse':sname,'PAddress':paddress,'PrAddress':praddress,'Photo':nidimg,'Ekyc':ekyc_stat}
print (json.dumps(user_data))