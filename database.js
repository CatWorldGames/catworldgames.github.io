var firebaseConfig = {
    apiKey: "AIzaSyCIYuUoD0MNpvJHODMSp76JEJRG_pm1egg",
    authDomain: "vkotomire.firebaseapp.com",
    databaseURL: "https://vkotomire.firebaseio.com",
    projectId: "vkotomire",
    storageBucket: "vkotomire.appspot.com",
    messagingSenderId: "710516320047",
    appId: "1:710516320047:web:1966bb2619557c8f8ea3da",
    measurementId: "G-GMWKZJ69G7"
  };
 
   firebase.initializeApp(firebaseConfig);
   
   var myName = prompt("Введите свое имя");
  var room = prompt("Введите название комнаты");