// node.js and firestore House Example
// Nov. 2019, croftd

// from: https://firebase.google.com/docs/firestore/quickstart

var admin = require("firebase-admin");

// You will need to point to your own private .json file
var serviceAccount = require("./disco-direction-254517-firebase-adminsdk-7wtte-6effb928a0.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://housenode-5ae6d.firebaseio.com"
});

const db = admin.firestore();

const express = require('express'); 
const app = express();
const bodyParser = require ('body-parser');
app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());
// use embedded javascript (EJS) for view templates
app.set('view engine', 'ejs');

// this tells express where to look for .js files to use with EJS views
app.use(express.static('public'));

// Base url with just '/'
app.get('/', function(req, res) {
	console.log("Processing request");
	
	db.collection('houses').get()
    .then(res2 => {
        let houseArray = [];
        res2.forEach(doc => {
          houseArray.push(doc.data());
        });

        // Note: render defaults to the views folder!
        res.render('index_v3.ejs', {houses: houseArray});			  

        // Note that res is from express responding to the original request
        console.log("Here is res: ");
        console.table(res);

        // res2 is the firestore response from Google
        console.log("Here is res2: ");
        console.table(res2);
    })
    .catch(err => { console.error(err) });
});

// note semi-colons

// Route to add a new house
app.post('/add', function(req, res) {
   console.log("Processing request to add a house...");
   console.log("Adding a house using tthe body-parser");
   
   db.collection('houses').doc().set({
   address: req.body.address,
   price: req.body.price,
   size: req.body.size,
   description: req.body.description,
   location: req.body.location
   })
});

// If you request the base URL at port 3000, with /houses, this function will run
app.get('/houses', function(req, res) {
    //app.get(‘/houses', (req, res) => {
	console.log("Processing request");
	res.json({houses: "Here is a sample from the houses route"});
	
	db.collection('houses').get()
    .then(res2 => {
      res2.forEach(doc => {
        console.log("House: " + doc.id);
        const data = doc.data();
        console.log(data);

        // Example of accessing individual field of the data object:
        console.log("Here is the price: " + data.price);
      });
    })
    .catch(err => { console.error(err) });
});

app.get('/maps', function(req, res) {
  console.log("Processing request for the map");
  db.collection('houses').get()
    .then(res2 => {
        let houseArray = [];
        res2.forEach(doc => {
          houseArray.push(doc.data());
        });

  //res.json({houses: "Here is a sample from the houes route"});
  res.render('map.ejs', {houses: houseArray});			  
})
});
app.get('/edit', function(req, res) {
  console.log("Processing request for the edit");
  db.collection('houses').get()
    .then(res2 => {
        let houseArray = [];
        res2.forEach(doc => {
          houseArray.push(doc.data());
        });

  //res.json({houses: "Here is a sample from the houes route"});
  res.render('index_v3.ejs', {houses: houseArray});			  
})
.catch(err => { console.error(err) });

});
app.listen(3000);
console.log("house app: server_v3.js listening on port 3000");
