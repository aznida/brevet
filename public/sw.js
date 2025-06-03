// Service Worker untuk menangani offline mode

const CACHE_NAME = 'brevet-offline-v1';
const OFFLINE_URL = '/offline.html';

// Install Service Worker dan cache halaman offline
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.add(new Request(OFFLINE_URL, { cache: 'reload' }));
    })
  );
  // Force service worker to activate immediately
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.filter((cacheName) => {
          return cacheName !== CACHE_NAME;
        }).map((cacheName) => {
          return caches.delete(cacheName);
        })
      );
    })
  );
  // Claim clients so the SW is in effect immediately
  self.clients.claim();
});

// Fetch event handler
self.addEventListener('fetch', (event) => {
  // We only want to handle GET requests
  if (event.request.method !== 'GET') return;

  event.respondWith(
    fetch(event.request).catch(() => {
      // If the fetch fails (offline), show the offline page
      return caches.match(OFFLINE_URL);
    })
  );
});