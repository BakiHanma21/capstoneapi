<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $serverKey;
    protected $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    public function __construct()
    {
        $this->serverKey = config('services.firebase.server_key');
    }

    /**
     * Send notification to a specific device
     *
     * @param string $token
     * @param array $notification
     * @param array $data
     * @param string $platform Optional - 'web', 'android', or 'ios'
     * @return mixed
     */
    public function sendNotification($token, $notification, $data = [], $platform = null)
    {
        try {
            // Base message structure
            $fields = [
                'to' => $token,
                'notification' => $notification,
                'data' => $data,
                'priority' => 'high'
            ];

            // Add platform-specific configurations
            if ($platform === 'android' || (isset($data['device_type']) && $data['device_type'] === 'android')) {
                // Android specific configuration
                $fields['android'] = [
                    'notification' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'channel_id' => 'high_importance_channel',
                        'priority' => 'high',
                        'sound' => 'default'
                    ]
                ];
            } elseif ($platform === 'ios' || (isset($data['device_type']) && $data['device_type'] === 'ios')) {
                // iOS specific configuration
                $fields['apns'] = [
                    'headers' => [
                        'apns-priority' => '10'
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => $notification['title'],
                                'body' => $notification['body']
                            ],
                            'badge' => 1,
                            'sound' => 'default'
                        ]
                    ]
                ];
            }

            // Always include these for mobile compatibility
            $fields['data']['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
            $fields['content_available'] = true;
            $fields['mutable_content'] = true;

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json'
            ])->post($this->fcmUrl, $fields);

            Log::info('FCM Notification sent', [
                'token' => $token,
                'notification' => $notification,
                'data' => $data,
                'platform' => $platform,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error sending FCM notification', [
                'error' => $e->getMessage(),
                'token' => $token
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send notification to multiple devices
     *
     * @param array $tokens
     * @param array $notification
     * @param array $data
     * @return mixed
     */
    public function sendMultipleNotifications($tokens, $notification, $data = [])
    {
        try {
            $fields = [
                'registration_ids' => $tokens,
                'notification' => $notification,
                'data' => $data,
                'priority' => 'high'
            ];

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json'
            ])->post($this->fcmUrl, $fields);

            Log::info('FCM Multiple Notifications sent', [
                'tokens_count' => count($tokens),
                'notification' => $notification,
                'data' => $data,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error sending multiple FCM notifications', [
                'error' => $e->getMessage(),
                'tokens_count' => count($tokens)
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send notification to a topic
     *
     * @param string $topic
     * @param array $notification
     * @param array $data
     * @return mixed
     */
    public function sendTopicNotification($topic, $notification, $data = [])
    {
        try {
            $fields = [
                'to' => '/topics/' . $topic,
                'notification' => $notification,
                'data' => $data,
                'priority' => 'high'
            ];

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json'
            ])->post($this->fcmUrl, $fields);

            Log::info('FCM Topic Notification sent', [
                'topic' => $topic,
                'notification' => $notification,
                'data' => $data,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error sending FCM topic notification', [
                'error' => $e->getMessage(),
                'topic' => $topic
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
} 