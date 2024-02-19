var http = require('http');
var admin = require("firebase-admin");
var express = require("express");
var date = require("./datemodule");
console.log("Im alive!");

var serviceAccount = require("./disco-direction-254517-firebase-adminsdk-7wtte-6effb928a0.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount)
});

let db = admin.firestore();

const app = express();
const port = 8080;
app.get('/', (req, res) => {
  let docRef = db.collection('Houses').doc('DZ6hsLjjHMM2d2ulJYp7');

  let setAda = docRef.set({
    size: 100,
  });

  return res.send('Hello World!' + date.myDateTime()); 
  
});
db.collection('Houses').get()
  .then((snapshot) => {
    snapshot.forEach((doc) => {
      console.log(doc.id, '=>', doc.data());
    });
  })
  .catch((err) => {
    console.log('Error getting documents', err);
  });
app.listen(port, () => {
    console.log(`Example app listening on port ${port}!`);
});