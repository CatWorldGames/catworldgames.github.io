var firebaseConfig = {
    apiKey: "AIzaSyDV3XMASdmKqixO8M6Ac-pWLK-9DgtQbe4",
    authDomain: "perepiska-8dde8.firebaseapp.com",
    databaseURL: "https://perepiska-8dde8.firebaseio.com",
    projectId: "perepiska-8dde8",
    storageBucket: "perepiska-8dde8.appspot.com",
    messagingSenderId: "807576450458",
    appId: "1:807576450458:web:5b252229ca8f3bb1bff623",
    measurementId: "G-Q113H12CFJ"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
room = localStorage.getItem("room");
