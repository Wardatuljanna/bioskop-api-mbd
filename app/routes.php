<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    // Table Customer
    // get, GetAllCustomer
    $app->get('/customers', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);
    
        $stmt = $db->prepare('CALL GetAllCustomer()');
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $response->getBody()->write(json_encode($results));
    
        return $response->withHeader('Content-Type', 'application/json');
    });

    // get, GetCustomerByID
    $app->get('/customer/{id}', function (Request $request, Response $response, $args) {
        $id_customer = $args['id'];

        $db = $this->get(PDO::class);

        $stmt = $db->prepare('CALL GetCustomerByID(?)');
        $stmt->bindParam(1, $id_customer, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($results));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // post, AddCustomer
    $app->post('/customers', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $id_customer = $parsedBody["id_customer"];
        $nama = $parsedBody["nama"];
        $db = $this->get(PDO::class);
    

        $query = $db->prepare('CALL AddCustomer(?, ?)');
        $query->bindParam(1, $id_customer, PDO::PARAM_INT);
        $query->bindParam(2, $nama, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(['message' => 'Customer berhasil ditambahkan!']));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // put, UpdateCustomer
    $app->put('/customer/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();

        $id_customer = $args['id'];
        $nama = $parsedBody["nama"];
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL UpdateCustomer(?, ?)');
        $query->bindParam(1, $id_customer, PDO::PARAM_STR);
        $query->bindParam(2, $nama, PDO::PARAM_STR);

        $response->getBody()->write(json_encode(
            [
                'message' => 'Customer dengan id ' . $id_customer . ' telah diupdate dengan nama ' . $nama
            ]
        ));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete, DeleteCustomer
    $app->delete('/customer/{id}', function (Request $request, Response $response, $args) {
        $id_customer = $args['id'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteCustomer(?)');
            $query->execute([$id_customer]);

            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Customer dengan id ' . $id_customer . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    //Table Film
    // get, GetAllFilm
    $app->get('/films', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);
    
        $stmt = $db->prepare('CALL GetAllFilm()');
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $response->getBody()->write(json_encode($results));
    
        return $response->withHeader('Content-Type', 'application/json');
    });

    // get, GetFilmByID
    $app->get('/film/{id}', function (Request $request, Response $response, $args) {
        $id_film = $args['id'];

        $db = $this->get(PDO::class);

        $stmt = $db->prepare('CALL GetFilmByID(?)');
        $stmt->bindParam(1, $id_film, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($results));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // post, AddFilm
    $app->post('/films', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $id_film = $parsedBody["id_film"];
        $judul = $parsedBody["judul"];
        $db = $this->get(PDO::class);
    

        $query = $db->prepare('CALL AddFilm(?, ?)');
        $query->bindParam(1, $id_film, PDO::PARAM_STR);
        $query->bindParam(2, $judul, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(['message' => 'Film berhasil ditambahkan!']));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // put, UpdateFilm
    $app->put('/film/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();

        $id_film = $args['id'];
        $judul = $parsedBody["judul"];
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL UpdateFilm(?, ?)');
        $query->bindParam(1, $id_film, PDO::PARAM_STR);
        $query->bindParam(2, $judul, PDO::PARAM_STR);

        $response->getBody()->write(json_encode(
            [
                'message' => 'Film dengan id ' . $id_film . ' telah diupdate dengan judul ' . $judul
            ]
        ));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete, DeleteFilm
    $app->delete('/film/{id}', function (Request $request, Response $response, $args) {
        $id_film = $args['id'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteFilm(?)');
            $query->execute([$id_film]);

            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Film dengan id ' . $id_film . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    //Table Jadwal
    // get, GetAllJadwal
    $app->get('/jadwals', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);
    
        $stmt = $db->prepare('CALL GetAllJadwal()');
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $response->getBody()->write(json_encode($results));
    
        return $response->withHeader('Content-Type', 'application/json');
    });

    // get, GetJadwalByID
    $app->get('/jadwal/{id}', function (Request $request, Response $response, $args) {
        $id_jadwal = $args['id'];

        $db = $this->get(PDO::class);

        $stmt = $db->prepare('CALL GetJadwalByID(?)');
        $stmt->bindParam(1, $id_jadwal, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($results));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // post, AddJadwal
    $app->post('/jadwals', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $id_jadwal = $parsedBody["id_jadwal"];
        $id_film = $parsedBody["id_film"];
        $jadwal = $parsedBody["jadwal"];
        $db = $this->get(PDO::class);
    

        $query = $db->prepare('CALL AddJadwal(?, ?, ?)');
        $query->bindParam(1, $id_jadwal, PDO::PARAM_STR);
        $query->bindParam(2, $id_film, PDO::PARAM_STR);
        $query->bindParam(3, $jadwal, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(['message' => 'Jadwal berhasil ditambahkan!']));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // put, UpdateJadwal
    $app->put('/jadwal/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();

        $id_jadwal = $args['id'];
        $jadwal = $parsedBody["jadwal"];
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL UpdateJadwal(?, ?)');
        $query->bindParam(1, $id_jadwal, PDO::PARAM_STR);
        $query->bindParam(2, $jadwal, PDO::PARAM_STR);

        $response->getBody()->write(json_encode(
            [
                'message' => 'Jadwal dengan id ' . $id_jadwal . ' telah diupdate dengan jadwal ' . $jadwal
            ]
        ));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete, DeleteJadwal
    $app->delete('/jadwal/{id}', function (Request $request, Response $response, $args) {
        $id_jadwal = $args['id'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteJadwal(?)');
            $query->execute([$id_jadwal]);

            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Jadwal dengan id ' . $id_jadwal . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    //Table Studio
    // get, GetAllStudio
    $app->get('/studios', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);
    
        $stmt = $db->prepare('CALL GetAllStudio()');
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $response->getBody()->write(json_encode($results));
    
        return $response->withHeader('Content-Type', 'application/json');
    });

    // get, GetStudioByID
    $app->get('/studio/{id}', function (Request $request, Response $response, $args) {
        $id_studio = $args['id'];

        $db = $this->get(PDO::class);

        $stmt = $db->prepare('CALL GetStudioByID(?)');
        $stmt->bindParam(1, $id_studio, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($results));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // post, AddStudio
    $app->post('/studios', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $id_studio = $parsedBody["id_studio"];
        $no_studio = $parsedBody["no_studio"];
        $kota = $parsedBody["kota"];
        $db = $this->get(PDO::class);
    

        $query = $db->prepare('CALL AddStudio(?, ?, ?)');
        $query->bindParam(1, $id_studio, PDO::PARAM_STR);
        $query->bindParam(2, $no_studio, PDO::PARAM_STR);
        $query->bindParam(3, $kota, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(['message' => 'Studio berhasil ditambahkan!']));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // put, UpdateStudio
    $app->put('/studio/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();

        $id_studio = $args['id'];
        $no_studio = $parsedBody["no_studio"];
        $kota = $parsedBody["kota"];
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL UpdateFilm(?, ?, ?)');
        $query->bindParam(1, $id_studio, PDO::PARAM_STR);
        $query->bindParam(2, $no_studio, PDO::PARAM_STR);
        $query->bindParam(3, $kota, PDO::PARAM_STR);

        $response->getBody()->write(json_encode(
            [
                'message' => 'Studio dengan id ' . $id_studio . ' telah diupdate dengan nomor studio ' . $no_studio 
            ]
        ));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete, DeleteStudio
    $app->delete('/studio/{id}', function (Request $request, Response $response, $args) {
        $id_studio = $args['id'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteStudio(?)');
            $query->execute([$id_studio]);

            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Studio dengan id ' . $id_studio . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    //Table Tiket
    // get, GetAllTiket
    $app->get('/tikets', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);
    
        $stmt = $db->prepare('CALL GetAllTiket()');
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $response->getBody()->write(json_encode($results));
    
        return $response->withHeader('Content-Type', 'application/json');
    });

    // get, GetTiketByID
    $app->get('/tiket/{id}', function (Request $request, Response $response, $args) {
        $kode_tiket = $args['id'];

        $db = $this->get(PDO::class);

        $stmt = $db->prepare('CALL GetTiketByID(?)');
        $stmt->bindParam(1, $kode_tiket, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($results));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // post, AddTiket
    $app->post('/tikets', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $kode_tiket = $parsedBody["kode_tiket"];
        $id_customer = $parsedBody["id_customer"];
        $id_film = $parsedBody["id_film"];
        $id_jadwal = $parsedBody["id_jadwal"];
        $id_studio = $parsedBody["id_studio"];
        $qty_tiket = $parsedBody["qty_tiket"];
        $harga = $parsedBody["harga"];
        $no_kursi = $parsedBody["no_kursi"];
        $db = $this->get(PDO::class);
    

        $query = $db->prepare('CALL AddTiket(?, ?, ?, ?, ?, ?, ?, ?)');
        $query->bindParam(1, $kode_tiket, PDO::PARAM_STR);
        $query->bindParam(2, $id_customer, PDO::PARAM_STR);
        $query->bindParam(3, $id_film, PDO::PARAM_STR);
        $query->bindParam(4, $id_jadwal, PDO::PARAM_STR);
        $query->bindParam(5, $id_studio, PDO::PARAM_STR);
        $query->bindParam(6, $qty_tiket, PDO::PARAM_INT);
        $query->bindParam(7, $harga, PDO::PARAM_INT);
        $query->bindParam(8, $no_kursi, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(['message' => 'Tiket berhasil ditambahkan!']));

        return $response->withHeader('Content-Type', 'application/json');
    });

    // put, UpdateTiket
    $app->put('/tiket/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();

        $kode_tiket = $args['id'];
        $harga = $parsedBody["harga"];
        $no_kursi = $parsedBody["no_kursi"];
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL UpdateTiket(?, ?)');
        $query->bindParam(1, $kode_tiket, PDO::PARAM_STR);
        $query->bindParam(2, $harga, PDO::PARAM_INT);
        $query->bindParam(3, $no_kursi, PDO::PARAM_STR);

        $response->getBody()->write(json_encode(
            [
                'message' => 'Tiket dengan id ' . $kode_tiket . ' telah diupdate dengan harga ' . $harga 
            ]
        ));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete, DeleteTiket
    $app->delete('/tiket/{id}', function (Request $request, Response $response, $args) {
        $kode_tiket = $args['id'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteTiket(?)');
            $query->execute([$kode_tiket]);

            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Tiket dengan id ' . $kode_tiket . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });
};
