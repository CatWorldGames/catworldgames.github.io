var firebaseConfig = {
    apiKey: "AIzaSyAAre7sBkOs4BHwqngR3yb66mYtUIdw2Mg",
    authDomain: "rpg1-ccb6a.firebaseapp.com",
    databaseURL: "https://rpg1-ccb6a.firebaseio.com",
    projectId: "rpg1-ccb6a",
    storageBucket: "rpg1-ccb6a.appspot.com",
    messagingSenderId: "209902203223",
    appId: "1:209902203223:web:18c9860490a678b9ca0e12",
    measurementId: "G-SSMJY6M541"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  var author = prompt("Введите название канала");
  var prevue = prompt("Вставьте ссылку на превью");
  var icon = "https://poisk-firm.ru/storage/employer/logo/06/35/dd/b553fadeec1674468df333dc27.png";
  var video = prompt("Введите ссылку видео");