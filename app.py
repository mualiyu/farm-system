import requests

# url = 'http://localhost:8000/api/actuator/uppdate/node/details'
url = 'http://hydrosensex.mukeey.online/api/actuator/uppdate/node/details'

nodeA = "1,31.00,31,191"
nodeB = "2,30.00,31,20"
pump = True
opr = True
dev = 123456789

myobj = {'nodes': {'1': nodeA, '2': nodeB}, 'pump': pump, 'operationMode': opr, 'device_id': dev}

x = requests.get(url, json = myobj)

print(x.text)