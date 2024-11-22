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
use Illuminate\Support\Facades\Validator;
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


    public function __construct(Client $client)
    {
        $this->client = $client;
        // $this->key = Config::get('VONAGE_APPLICATION_ID');
        $this->key = env('VONAGE_APPLICATION_ID');
        $privateKeyPath = storage_path('app/private.key');
        $this->privateKeyContent = file_get_contents($privateKeyPath);
    }

    public function index() {
        $meetings = Room::orderby('id', 'desc')->get();
        return Inertia::render('Dashboard', [
            'meetings' => $meetings,
        ]);
    }

    public function joinRoom(Request $request,$id): Response
    {

        $room = Room::findOrFail($id);               
        $this->session_id = $room->session_id;
        $this->token = $this->client->video()->generateClientToken($room->session_id);
        return Inertia::render('Room', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'apikey' => $this->key,
            'session_id' => $this->session_id,
            'token' => $this->token,
            'privatekey' => $this->privateKeyContent
        ]);
    }

    public function previewRoom(Request $request,$id): Response
    {
        
        $room = Room::findOrFail($id);       
        $this->session_id = $room->session_id;
        $this->token = $this->client->video()->generateClientToken($room->session_id);
        return Inertia::render('Preview', [
            'status' => session('status'),
            'apikey' => $this->key,
            'session_id' => $this->session_id,
            'token' => $this->token,
            'privatekey' => $this->privateKeyContent,
            'room' => $room,
        ]);
    }

    public function createRoom()
    {
        return Inertia::render('Room/Create', [
            'apikey' => $this->key,
            'token' => $this->token,
            'privatekey' => $this->privateKeyContent
        ]);
    }

    public function storeMeeting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meeting_name' => 'required|string|max:255|unique:rooms,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], status: 422);
        }
        $vonageVideoClient = $this->client->video();
            $sessionOptions = new SessionOptions([
                'archiveMode' => ArchiveMode::ALWAYS,
                'mediaMode' => MediaMode::ROUTED
            ]);
            $session = $vonageVideoClient->createSession($sessionOptions);
            $sessionId = $session->getSessionId();
            
        $room = new Room(['name' => $request->meeting_name, 'session_id' => $sessionId]);
        $room->save();
        return response()->json([
            'message' => 'Room created successfully!',
        ]);
    }
}
