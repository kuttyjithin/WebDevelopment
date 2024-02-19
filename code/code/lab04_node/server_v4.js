// node.js and firestore House Example
// Dec. 2019, croftd

// from: https://firebase.google.com/docs/firestore/quickstart

var admin = require("firebase-admin");

// You will need to point to your own private .json file
//var serviceAccount = require("./private/housenode-5ae6d-firebase-adminsdk-515bs-acc7700b6e.json");
var serviceAccount = require("./disco-direction-254517-firebase-adminsdk-7wtte-6effb928a0.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://housenode-5ae6d.firebaseio.com"
});

// get the database connection to Google Firestore
const db = admin.firestore();

// Express is a Node.js Model-View-Controller framework
const express = require('express'); 
const app = express();

// body-parser is to help get data from form inputs into the request object
// croftd: NOTE bodyParser does not support multi-part form data!!
// so if you have a form with enctype="multipart/form-data" this will not work
const bodyParser= require('body-parser');

// The urlencoded method within body-parser tells body-parser to extract 
// data from the <form> element and add them to the body property in
// the request object. This is required to receive the fetch put from main.js
app.use(bodyParser.json());

// this helps us read data from the form post 
app.use(bodyParser.urlencoded({ extended: true }));

// Multer is for multipart form uploads!
// Note: body-parser handles regular forms, multer handles multi-part
var multer  = require('multer');
var upload = multer({ dest: 'uploads' });
var geohash = require('geohash').GeoHash;
// use embedded javascript (EJS) for view templates
app.set('view engine', 'ejs');

// this tells express to allow serving files from 'public' folders
app.use(express.static('public'));
// also tell express to serve photos uploaded
app.use(express.static('uploads'));

// croftd
// We are trying to build a RESTful API!
// This could be accessed from a browser or a mobile app
// CRUD
// Create
// Read
// Update
// Delete

// READ (The R in CRUD!)
// Base url with just '/' - show a list of all the houses
app.get('/', function(req, res) {
	console.log("Processing / route request...");
	
	db.collection('houses').get()
    .then(res2 => {
        let houseArray = [];
        res2.forEach(doc => {
          // create an object with Document data from Firestore
          var houseData = doc.data();
          // we need to add the id field (this is the unique auto generate identifier from Firestore)
          houseData.id = doc.id;
          houseArray.push(houseData);
          console.log(houseData);
        });

        // Note: render defaults to the views folder!
        res.render('index_v4.ejs', {houses: houseArray, house: null, action: "/house/add"});	
    })
    .catch(err => { console.error(err) });
});

// TEST
// for testing bodyy-parser for the test form post 
// see main.js for the test button
app.post('/test', function(req, res) {
  console.log("Here is the test route to test body-parser is working");
  console.log("Here is the request test: " + req.body.test);
  console.log("Here is the request.body: ");
  console.table(req.body);
  res.send("Test complete! Look at the console");
});

// CREATE - Show the add form
app.get('/house/add', function(req, res) {
  res.render('house/add.ejs', { house: null, action: "/house/add"});
});

// CREATE
// Route from post when submitting a form to add a new house
// croftd: note we added the second parameter 'upload' to use multer to 
// handle the multipart form rather than body-parser
app.post('/house/add', upload.array('photos', 12), function(req, res) {
   console.log("Processing /house/add route request...");
    
   // note body-parser allows us to access the named inputs in the body
    // e.g.:
    console.log("Adding new house from req.body: ")
    console.table(req.body);
   
   // if you have multer configured correctly, you should be 
   // able to get the variables from the 'Add House' form e.g.:
   // NOTE: body-parser doesn't work with multipart forms! we need multer!
   let userAddress = req.body.address;

   // TODO: get the rest of the form inputs!

   // The code to handle photos for file upload input is complete below

  console.log("Here is req.files for photos:...");
	console.log(req.files);
  //console.log(req.files[0].originalname);
	// Add the photos uploaded to req.body
  const userPhotos = Array();
  //console.log(req.files.length);
 // console.log(req.files[0].filename);
    for(let i=0; i<req.files.length; i++) {
    userPhotos.push(req.files[i].filename);
     }
  
   // create a new Firestore Document
   let docRef = db.collection('houses').doc();
   let userLat = Number(req.body.userLat);
   let userLong = Number(req.body.userLong);
   // TODO: Firebase code to set the data for this new house!
   // Note the Firebase GeoPoint will be something like
   //  location: new admin.firestore.GeoPoint(userLat, userLong)
   // set the data for this Document
   db.collection('houses').doc().set({
    address: req.body.address,
    price: req.body.price,
    size: req.body.size,
    description: req.body.description,
    photos: userPhotos,
    //location: req.body.location
    location: new admin.firestore.GeoPoint(userLat, userLong)
    })

   console.log("New house added at address: " + userAddress);
   res.redirect('/');
});	
app.get('/maps', function(req, res) {
  console.log("Processing request for the map");
  db.collection('houses').get()
    .then(res2 => {
        let houseArray = [];
        res2.forEach(doc => {
        var houseData=doc.data();
        houseData.id=doc.id;
          houseArray.push(houseData);
          console.log(houseData);
        });

  //res.json({houses: "Here is a sample from the houes route"});
  res.render('map.ejs', {houses: houseArray});			  
})
});
app.get('/maps/:variable', function(req, res) {
  console.log("Processing request for the map");
  let id = req.params.variable;
  console.log("Adding pointer for this id: " + id);
  db.collection('houses').doc(id).get()
    .then(doc => {
        let houseArray = [];
        houseArray=doc.data();
        var lat = houseArray.location._latitude;
        var long = houseArray.location._longitude;
        console.log("lat"+lat+"long"+long);
  //res.json({houses: "Here is a sample from the houes route"});
  res.render('mapp.ejs', {layout: false, lat:lat , lon:long });			  
})
});

// EDIT - croftd: This code should be working!
app.get('/house/edit/:variable', function(req, res) {

  console.log("Processing /house/edit request...");

  let id = req.params.variable;
  console.log("Editing house: " + id);
  
  let houseRef = db.collection('houses').doc(id);
  let getDoc = houseRef.get()
  .then(doc => {
    if (!doc.exists) {
      console.log("Error editing house: " + id + " No such document!");
    } else {
      console.log('Editing house with current data:', doc.data());

      var houseData = doc.data();
      // we need to add the id field (this is the unique auto generate identifier from Firestore)
      houseData.id = doc.id;

      res.render('house/edit.ejs', {house: houseData});	
    }
  })
  .catch(err => {
    console.log('Error editing house', err);
  });
});

// UPDATE 
// is very similar to edit - we need to retrieve a single house by ID
app.post('/house/update/:variable', upload.array('photos', 12), function(req, res) {

  console.log("Processing /house/update request...");

  let id = req.params.variable;
  console.log("Updating house: " + id);

  let houseRef = db.collection('houses').doc(id);
  let getDoc = houseRef.get()
  .then(doc => {
    if (!doc.exists) {
      console.log("Error updating house: " + id + " No such document!");
    } else {
      console.log('Updating house with current data:', doc.data());

      var houseData = doc.data();
      let userLat = Number(req.body.userLat);
      let userLong = Number(req.body.userLong);
      const userPhotos = Array();
  //console.log(req.files.length);
 // console.log(req.files[0].filename);
    for(let i=0; i<req.files.length; i++) {
      userPhotos.push(req.files[i].filename);
     }
      // We need to get the data from the form, same idea as adding a new house
      // Except we will use an existing Document reference
      // TODO
      // Need to write Google firestore database query to update this house!
      // houseRef.set({
        db.collection('houses').doc(id).set({
          address: req.body.address,
          price: req.body.price,
          size: req.body.size,
          description: req.body.description,
          photos: userPhotos,
          //location: req.body.location
          location: new admin.firestore.GeoPoint(userLat, userLong)
          })
      //res.send("House at address: " + houseData.address + " updated");
      res.redirect('/');
    }
  })
  .catch(err => {
    console.log('Error editing house', err);
  });
});

// DELETE
app.get('/house/delete/:variable', function(req, res) {

    let houseId = req.params.variable;

    console.log("Processing /house/delete request for ID: " + houseId);
    

    // TODO: Firebase function to delete the house with specified ID
    db.collection('houses').doc(houseId).delete();

    console.log("House " + houseId + " deleted!");
    
    res.render('house/delete.ejs', {id: houseId});

 });

// simple route for an about page...
app.get('/about', function(req, res) {
  res.render('about.ejs');
});

// After setting up the various routes, we start the application
// to listen for requests!
//
var port = 3000;
app.listen(port);
console.log("house app: server_v4.js listening on port " + port);
