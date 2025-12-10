<?php
namespace TDM;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService {
    public function getAlbums() {
        // Cargar variables
        EnvLoader::load();

        try {
            $session = new Session(
                $_ENV['SPOTIFY_CLIENT_ID'] ?? getenv('SPOTIFY_CLIENT_ID'),
                $_ENV['SPOTIFY_CLIENT_SECRET'] ?? getenv('SPOTIFY_CLIENT_SECRET')
            );
            
            $session->requestCredentialsToken();
            $accessToken = $session->getAccessToken();

            $api = new SpotifyWebAPI();
            $api->setAccessToken($accessToken);

            $artistId = $_ENV['SPOTIFY_ARTIST_ID'] ?? getenv('SPOTIFY_ARTIST_ID');

            // MODIFICACIÓN: Aumentamos el límite a 50 para traer todo
            return $api->getArtistAlbums($artistId, [
                'limit' => 50, // Traer hasta 50 lanzamientos (Máximo permitido por página)
                'include_groups' => ['album', 'single'], // Spotify incluye los EPs dentro de 'album' o 'single'
                'market' => 'CL'
            ]);
        } catch (\Exception $e) {
            // En producción, loguear el error
            return [];
        }
    }
}
?>