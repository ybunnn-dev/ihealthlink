<?php

namespace App\Services\Notifications;

use Exception;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FireBase
{
    public static function send($heading, $message, $deviceIds, $data = [])
    {
        // Filter out empty/null tokens
        $deviceIds = array_values(array_filter($deviceIds));
        
        if (empty($deviceIds)) {
            throw new Exception('No device IDs provided');
        }

        // Get OAuth2 access token
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = new ServiceAccountCredentials(
            $scopes, 
            config('services.firebase.credentials')
        );
        
        $accessToken = $credentials->fetchAuthToken()['access_token'];
        $projectId = config('services.firebase.project_id');

        $client = new Client();
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $successCount = 0;
        $failureCount = 0;
        $responses = [];

        // IMPORTANT: Send one request per token (FCM v1 API limitation)
        foreach ($deviceIds as $token) {
            $messagePayload = [
                'message' => [
                    'token' => $token, // Single token only
                    'notification' => [
                        'title' => $heading,
                        'body' => $message,
                    ],
                    'android' => [
                        'priority' => 'high',
                        'notification' => [
                            'sound' => 'default',
                            'channel_id' => 'high_importance_channel',
                        ],
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'sound' => 'default',
                            ],
                        ],
                    ],
                    'webpush' => [
                        'notification' => [
                            'title' => $heading,
                            'body' => $message,
                            'icon' => '/favicon.ico',
                        ],
                    ],
                ]
            ];

            // Add data payload if provided
            if (!empty($data)) {
                // Convert all data values to strings (FCM requirement)
                $messagePayload['message']['data'] = array_map('strval', $data);
            }

            try {
                $response = $client->request('POST', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $messagePayload,
                ]);

                $successCount++;
                $responses[] = [
                    'token' => $token,
                    'success' => true,
                    'response' => json_decode($response->getBody(), true)
                ];

                Log::info("FCM notification sent successfully to token: " . substr($token, 0, 20) . "...");

            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $failureCount++;
                $errorBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response';
                
                Log::error("FCM Error for token " . substr($token, 0, 20) . "...: " . $errorBody);
                
                $responses[] = [
                    'token' => $token,
                    'success' => false,
                    'error' => $errorBody
                ];
            }
        }

        Log::info("FCM Batch Complete: {$successCount} success, {$failureCount} failures out of " . count($deviceIds) . " tokens");

        return [
            'success_count' => $successCount,
            'failure_count' => $failureCount,
            'responses' => $responses
        ];
    }
}
