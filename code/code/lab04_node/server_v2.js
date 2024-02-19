// node.js and firestore House Example
// Nov. 2019, croftd

// from: https://firebase.google.com/docs/firestore/quickstart

var admin = require("firebase-admin");

// You will need to point to your own private .json file
var serviceAccount = require("./private/housenode-5ae6d-firebase-adminsdk-515bs-acc7700b6e.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://housenode-5ae6d.firebaseio.com"
});

const db = admin.firestore();

const express = require('express'); 
const app = express();

// If you request the base URL at port 3000, with /houses, this function will run
app.get('/houses', function(req, res) {
    //app.get(‘/houses', (req, res) => {
	console.log("Processing request");
	res.json({houses: "Here is a sample from the houses route"});
	
	db.collection('houses').get()
    .then(res => {
      res.forEach(doc => {
        console.log("House: " + doc.id);
        const data = doc.data();
        console.log(data);

        // Example of accessing individual field of the data object:
        console.log("Here is the price: " + data.price);
      });
    })
    .catch(err => { console.error(err) });
});

app.listen(3000);
console.log("house app: index.js listening on port 3000");
