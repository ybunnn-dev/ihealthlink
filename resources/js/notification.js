export default () => ({
    notifications: [],
    unreadCount: 0,

    init() {
        this.loadNotifications();
        this.setupFirebase();
        setInterval(() => this.loadNotifications(), 30000);
    },

    async loadNotifications() {
        try {
            const response = await fetch('/notifications');
            const data = await response.json();
            this.notifications = data.notifications;
            this.unreadCount = data.unread_count;
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    },

    async markAsRead(id) {
        try {
            await fetch(`/notifications/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            this.loadNotifications();
        } catch (error) {
            console.error('Error marking as read:', error);
        }
    },

    async markAllRead() {
        try {
            await fetch('/notifications/read-all', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            this.loadNotifications();
        } catch (error) {
            console.error('Error marking all as read:', error);
        }
    },

    formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);

        if (diff < 60) return 'Just now';
        if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
        if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
        return `${Math.floor(diff / 86400)} days ago`;
    },

    async setupFirebase() {  
        try {
            const { initializeApp } = await import('https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js');
            const { getMessaging, getToken, onMessage } = await import('https://www.gstatic.com/firebasejs/11.0.1/firebase-messaging.js');
            
            const firebaseConfig = {
                apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
                authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
                projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
                storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
                messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
                appId: import.meta.env.VITE_FIREBASE_APP_ID
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);

            const permission = await Notification.requestPermission();
            
            if (permission === 'granted') {
                const token = await getToken(messaging, {
                    vapidKey: import.meta.env.VITE_FIREBASE_VAPID_KEY
                });

                if (token) {
                    await fetch('/firebase/token', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ fcm_token: token })
                    });
                }
            }

            onMessage(messaging, (payload) => {
                console.log('Message received:', payload);
                this.loadNotifications();
                
                new Notification(payload.notification.title, {
                    body: payload.notification.body,
                    icon: '/favicon.ico'
                });
            });
        } catch (error) {
            console.error('Firebase setup error:', error);
        }
    }
});
