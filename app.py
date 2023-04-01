import requests

url = 'http://localhost:3000/api/actuator/uppdate/node/details'

nodeA = "1,31.00,31,191"
nodeB = "2,30.00,31,20"
pump = True
opr = False
dev = 123456789

myobj = {'nodes': {'1': nodeA, '2': nodeB}, 'pump': pump, 'operationMode': opr, 'device_id': dev}

x = requests.post(url, json = myobj)

print(x.text)