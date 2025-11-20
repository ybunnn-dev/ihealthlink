// public/firebase-messaging-sw.js

importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

// Replace these with your actual Firebase config values
firebase.initializeApp({
    apiKey: "AIzaSyDOqIufHbSKAgxnr0FlIsylj7CJjzyQiks",
    authDomain: "ihealthlink-notification.firebaseapp.com",
    projectId: "ihealthlink-notification",
    storageBucket: "ihealthlink-notification.firebasestorage.app",
    messagingSenderId: "156915535205",
    appId: "1:156915535205:web:669345ad9a79fcb254a58c"
});

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {

    
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        data: payload.data
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification clicks
self.addEventListener('notificationclick', (event) => {
    console.log('[firebase-messaging-sw.js] Notification click received.');
    
    event.notification.close();
    
    // Open your app when notification is clicked
    event.waitUntil(
        clients.openWindow('https://ihealthlink-daraga.site')
    );
});
