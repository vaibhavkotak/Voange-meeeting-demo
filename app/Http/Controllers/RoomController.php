<?php

namespace App\Http\Controllers;

use Vonage\Client;
use App\Models\Room;
use Inertia\Inertia;
use OpenTok\OpenTok;
use Inertia\Response;

use Vonage\Video\MediaMode;
use Illuminate\Http\Request;
use Vonage\Client\APIResource;
use Vonage\Video\CaptionOptions;
use Vonage\Video\SessionOptions;
use Vonage\Video\Archive\ArchiveMode;
use Illuminate\Support\Facades\Config;
use Vonage\Client\Credentials\Keypair;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class RoomController extends Controller
{
    protected $key;
    protected $client;
    public $session_id;
    public $token;
    public $privateKeyContent;



    public $credentials;
    public $apiResource;
    public $newClient;


    public function __construct(Client $client) {
        $this->client = $client;
        // $this->key = Config::get('VONAGE_APPLICATION_ID');
        $this->key = env('VONAGE_APPLICATION_ID');
        $privateKeyPath = storage_path('app/private.key');
        $this->privateKeyContent = file_get_contents($privateKeyPath);
        
       
    }

    public function joinRoom(Request $request): Response {
        
        // $credentials = new Keypair($privateKeyContent, 'e85dac19-ee06-4cc2-a2a6-5db74efa4b1b');
        // $client = new Client($credentials);
        // $opentok = new OpenTok('e85dac19-ee06-4cc2-a2a6-5db74efa4b1b', 'a1OOSiK9aBBXGAV5');
        // $client = new OpenTok('e85dac19-ee06-4cc2-a2a6-5db74efa4b1b',$privateKeyContent);
        // $sessionOptions = [
        //     // 'mediaMode' => MediaMode::ROUTED,
        //     'archiveMode' => ArchiveMode::ALWAYS,
        // ];
        // $session = $client->createSession();
        // dd($session);
        
        $room = Room::where('name','demo-room-test')->first();
        if(!$room) {
            $vonageVideoClient = $this->client->video();
            $sessionOptions = new SessionOptions([
                'archiveMode' => ArchiveMode::ALWAYS,
                'mediaMode' => MediaMode::ROUTED
            ]);
            // $session = $vonageVideoClient->createSession();
            $session = $vonageVideoClient->createSession($sessionOptions);
            $sessionId = $session->getSessionId();
            // $token = $vonageVideoClient->generateClientToken($sessionId);
            $room = new Room(['name' => 'demo-room-test','session_id' => $sessionId]);
            $room->save();            
        }
        $this->session_id = $room->session_id;        
        $this->token = $this->client->video()->generateClientToken($room->session_id);
        // dd( $this->key,$room->session_id,$this->client->video()->generateClientToken($room->session_id));
        return Inertia::render('Room', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'apikey' => $this->key,
            'session_id' => $this->session_id,
            'token' => $this->token,
            'privatekey' => $this->privateKeyContent
        ]);
        // return view('room', [
        //     'apikey' => $this->key,
        //     'session_id' => $room->session_id,
        //     'token' => $this->client->video()->generateClientToken($room->session_id),
        //     // 'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjYwNTk4NjMsImV4cCI6MTcyNjA4MTQ2MywianRpIjoiSEF3QzN0blNtaDJEIiwiYXBwbGljYXRpb25faWQiOiJlODVkYWMxOS1lZTA2LTRjYzItYTJhNi01ZGI3NGVmYTRiMWIiLCJzdWIiOiIiLCJhY2wiOiIifQ.GlR8mJvCmfjLdzZwcaFxZIKNvtQnY4XoOKTqpl4qPSriZ98M5FTFhya7AWO31G9pD_cmESkVKQufYn8MmKM2_Mr-PKZFyxRAbmsLkMR01HUdX5zzTPqela-siJ6SOyyoksNz0dC_q6hkWiUzBaKW7MJi127IHRnC623bO1tb9So_n3ObXlyIEZ8m_WQu3Dtwtf0A5R6kuedQ9N2nbRMbfcQawO8iusQ0lDG9e5c1cX3pdye7HQR1yO4rKh6aSWqcziNOn4KomOgJR1F6yo4EH5doUa_wx_Sj2_28VPv-QId6zPo3v1FnO0xKdDXx17X3VDUmISdXdiCcObPosS0aAA',
        // ]);
    }

    public function previewRoom(Request $request): Response {
        $room = Room::where('name','demo-room-test')->first();
        $this->session_id = $room->session_id;        
        $this->token = $this->client->video()->generateClientToken($room->session_id);
        return Inertia::render('Preview', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'apikey' => $this->key,
            'session_id' => $this->session_id,
            'token' => $this->token,
            'privatekey' => $this->privateKeyContent
        ]);
    }

    public function startCaptionsShow(Request $request)
    {
        // Extract sessionId and token from the request
        $sessionId = $request->input('sessionId');
        $token = $request->input('token');
        // dd($sessionId,$token);

        // Optional: Define custom caption options (e.g., language, style, etc.)
        $captionOptions = new CaptionOptions();
        $captionOptions->setLanguageCode('en-US');  // Set language to English (or any language)
        // dd($captionOptions);
        try {
            // Start captions using the Vonage Video API
            $captionResponse = $this->fetchCaption($sessionId, $token, $captionOptions);





            return response()->json([
                'id' => $captionResponse['id'] ?? 'no_id_returned',  // Return the caption ID
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function stopCaptions($id)
    {
        try {
            // Stop captions using the Vonage Video API
            $result = $this->client->stopCaptions($id);

            if ($result) {
                return response()->json([
                    'message' => 'Captions stopped successfully.',
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed to stop captions.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchCaption(string $sessionId, string $token, ?CaptionOptions $captionOptions = null){

        $payload = [
            'sessionId' => $sessionId,
            'token' => $token
        ];

        if (!is_null($captionOptions)) {
            $payload = array_merge($payload, $captionOptions->toArray());
        }

        return $this->client->getAPIResource()->create($payload, '/v2/project/' . 'e85dac19-ee06-4cc2-a2a6-5db74efa4b1b' . '/captions');


    }
}
