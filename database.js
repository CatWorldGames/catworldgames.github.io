var firebaseConfig = {
    apiKey: "AIzaSyCIYuUoD0MNpvJHODMSp76JEJRG_pm1egg",
    authDomain: "vkotomire.firebaseapp.com",
    databaseURL: "https://vkotomire.firebaseio.com",
    projectId: "vkotomire",
    storageBucket: "video-2e5ed.appspot.com"
    appId: "1:710516320047:web:1966bb2619557c8f8ea3da",
    measurementId: "G-GMWKZJ69G7"
  };
 
   firebase.initializeApp(firebaseConfig);
   
   var myName = localStorage.getItem("username");
   var room = localStorage.getItem("room");
 
