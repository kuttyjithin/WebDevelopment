// node.js and firestore House Example
// Nov. 2019, croftd

// from: https://firebase.google.com/docs/firestore/quickstart

var admin = require("firebase-admin");

var serviceAccount = require("./private/housenode-5ae6d-firebase-adminsdk-515bs-acc7700b6e.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://housenode-5ae6d.firebaseio.com"
});

const db = admin.firestore();

const express = require('express'); 
const app = express();

// Note we could remove the function keyword if we wanted, for clarity I will leave it in
//app.get(‘/houses', (req, res) => {
app.get('/houses', function(req, res) {
	
	console.log("Processing /houses route");	
	//console.log(req);	
	res.json({houses: "Here is a sample from the houses route"});
});

app.listen(3000);
console.log("house app: index.js listening on port 3000");
