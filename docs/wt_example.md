# Living Room Lamp
## Root Resource: 
URL: `/living-room-lamp`
Returns:
```http
Link: <model/>; rel="model"
Link: <product/>; rel="product"
Link: <properties/>; rel="properties"
Link: <actions/>; rel="actions"
Link: <product/>; rel="product"
Link: <type/>; rel="type"
Link: <help/>; rel="help"
Link: <ui/>; rel="ui"
```

```json

{
   "id":"living-room-lamp",
   "name":"Living Room Lamp",
   "description":"The lamp in the living room",
   "createdAd":"2012-08-24T17:29:11.683Z",
   "updatedAd":"2012-08-24T17:29:11.683Z",
   "tags":[
      "lamp",
      "device",
      "actuator"
   ]
}
```
## Model: 
URL: `/living-room-lamp/model`
Returns:

```json
{
   "id":"living-room-lamp",
   "name":"Living Room Lamp",
   "brand":"panasonic",
   "description":"The lamp in the living room",
   "createdAd":"2012-08-24T17:29:11.683Z",
   "updatedAd":"2012-08-24T17:29:11.683Z",
   "tags":[
      "lamp",
      "device",
      "actuator"
   ],
   "links":{
      "product":{
         "link":"https://www2.meethue.com/en-us",
         "title":"This product is basaed on"
      },
      "properties":{
         "link":"/properties",
         "title":"List of properties",
         "resources":{
            "status":{
               "name":"Current lamp status",
               "description":"The current dimmable lamp status",
               "unit":"lumens"
            }
         }
      },
      "actions":{
         "link":"/actions",
         "title":"Actions of the lamp",
         "resources":{
            "bulbState":{
               "values":{
                  "state":{
                     "type":"boolean",
                     "required":true
                  }
               }
            }
         }
      }
   }
}
```

Properties: `living-room-lamp/properties/`
...
