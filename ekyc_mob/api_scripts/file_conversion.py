import os
path = '//192.107.2.154/dbh-fsdata/dbh_all/ekyc_img/'
#path='C:/Users/md.ashik/Desktop/New folder'
files = os.listdir(path)
count=0
esc=0
for index, file in enumerate(files):
    filename, file_extension = os.path.splitext(os.path.join(path,file))
    if file_extension=='.png':
        os.rename(os.path.join(path, file), os.path.join(path, ''.join([filename, '.jpg'])))
        count=count+1
    else:
        esc=esc+1
print(count,esc)  