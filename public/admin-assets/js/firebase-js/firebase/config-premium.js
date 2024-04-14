
        const firebaseConfig = {
            apiKey: "AIzaSyAWOGL6pGeioj04YALVhjlDm03llLSi5cs",
            authDomain: "diawanpremium-6d4a9.firebaseapp.com",
            databaseURL: "https://diawanpremium-smart-home-5758.asia-southeast1.firebasedatabase.app",
            projectId: "diawanpremium-6d4a9",
            storageBucket: "diawanpremium-6d4a9.appspot.com",
            messagingSenderId: "119160770965",
            appId: "1:119160770965:web:1ee90fdf4ed3a1fe9c669c",
            measurementId: "G-RRRZW6MKS0"
        };

        // Initialize Firebase
        // const app = initializeApp(firebaseConfig);

        const app = firebase.initializeApp(firebaseConfig);
        var database_premium = firebase.database();
