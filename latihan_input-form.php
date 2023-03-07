<html>

<head>
    <title>PROGRAM INPUT FORM</title>
</head>

<body>
    <h2>
        <center>FORM PENGECHECKAN HARGA BUAH</center>
    </h2>
    <!-- fungsi membuat inputan form -->
    <form action="" method="post">
        <div>
            <label>Nama Buah :
                <!-- membuat inputan menggunakan combo-box -->
                <select name="daftar_buah">
                    <!-- kondisi array -->
                    <?php
                    $buah = array('-- Pilih Buah --', 'Jambu', 'Mangga', 'Durian', 'Apel');
                    //fungsi untuk menampilkan dan mengurutkan data menggunakan array
                    sort($buah);
                    foreach ($buah as $value) {

                    ?>
                        <option value="<?php echo ($value); ?>"><?php echo $value; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
        </div>
        <br>
        <!-- membuat inputan menggunakan text field -->
        <div>
            <label>Jumlah Buah :</label>
            <input type="text" name="jml_buah" placeholder="Masukan Jumlah" id="">
        </div>
        <p>
            <label>
                <!-- membuat inputan menggunakan submit-->
                <input type="submit" name="check" value="Check" />
            </label>
        </p>
    </form>
    <hr>

    <?php
    function totalItem($a, $b, $c, $d)
    {
        $total  = $a + $b + $c + $d;
        return  $total;
    }

    $berkas     = "buah/file.json";
    $dataBuah   = array();

    $dataJson   = file_get_contents($berkas);
    $dataBuah   = json_decode($dataJson, true);

    //echo "$berkas"; //menampilkan isi data json
    //echo "<br><br>";
    //print_r($dataBuah); //menampilkan isi dataCustomer yang sudah berupa array

    ?>

    <!-- script dibawah ini dibuat untuk menampilkan hasil dari inputan form ketika tombol submit pengechekkan berfungsi-->
    <?php
    //fungsi untuk menghitung total harga buah menggunakan variabel
    function pembayaran_awal($list_harga, $quantity)
    {
        $bayarAwalan = $list_harga * $quantity;
        return $bayarAwalan;
    }

    if (isset($_POST['check'])) {

        echo "<p style=color:red>", "Hasil Perhitungan</p>";
        //membuat variabel
        $nama_buah = $_POST['daftar_buah'];
        $quantity = $_POST['jml_buah'];


        //menampilkan data berdasarkan nama buah dan harga
        if ($nama_buah == "Jambu") {
            $list_harga = 10000;
            echo "Nama Buah : " . $nama_buah . "<br>";
            echo "Harga : " . $list_harga . "/Kg <br>";
        } elseif ($nama_buah == "Mangga") {
            $list_harga = 15000;
            echo "Nama Buah : " . $nama_buah . "<br>";
            echo "Harga     : " . $list_harga . "/Kg <br>";
        } elseif ($nama_buah == "Durian") {
            $list_harga = 20000;
            echo "Nama Buah : " . $nama_buah . "<br>";
            echo "Harga     : " . $list_harga . "/Kg <br>";
        } else {
            $list_harga = 25000;
            echo "Nama Buah : " . $nama_buah . "<br>";
            echo "Harga     : " . $list_harga . "/Kg <br>";
        }
        //menampilkan data sesuai jumlah data buah yang di input
        echo "Jumlah        : " . $quantity . "<br><br>";


        //variabel ini berisi nilai bayar diawal dengan menggunakan fungsi bayar_awal dan
        //eksekusi menampilkan data total 
        $bayarAwalan = pembayaran_awal($quantity, $list_harga);
        echo "Total     : " . $bayarAwalan . "<br>";

        //ekseskusi perhitungan menggunakan diskon dan tanpa menggunakan diskon
        if ($bayarAwalan >= 100000) {
            $diskon = 0.05 * $bayarAwalan;
        } else {
            $diskon = 0;
        }
        //ekseskusi menampilkan data menggunakan diskon dan tanpa menggunakan diskon
        echo "Diskon 5% : " . $diskon . "<br>";

        //ekseskusi perhitungan dan menampilkan data dari total harga keseluruhan yang harus dibayar
        $pembayaran_akhir = $bayarAwalan - $diskon;
        echo "Bayar     : " . $pembayaran_akhir . "<br>";
        $dataNew = array(
            'nama_buah' => $_POST['daftar_buah'],
            'quantity' => $_POST['jml_buah'],

            'list_harga' => $list_harga,
            'bayarAwalan' => $bayarAwalan,
            'diskon' => $diskon,
            'pembayaran_akhir' => $pembayaran_akhir,
        );

        array_push($dataBuah, $dataNew); //Menambahkan data baru ke dalam data yang sudah ada dalam berkas. 
        //Mengkonversi kembali data customer dari array PHP menjadi array Json dan menyimpannya ke dalam berkas.
        $dataJson = json_encode($dataBuah, JSON_PRETTY_PRINT);
        file_put_contents($berkas, $dataJson);
    }
    ?>

    <table style="width:100%" border="1">
        <h2>
            <center>DATA TABLE</center>
        </h2>
        <tr>
            <th>Nama Buah</th>
            <th>Harga Buah</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Diskon 5%</th>
            <th>Bayar</th>
        </tr>

        <?php

        //	Perulangan untuk menampilkan data customer.
        //	Variabel $i adalah index data customer pada array $dataCustomer.
        for ($i = 0; $i < count($dataBuah); $i++) {

            //	Memindahkan data dari dalam array $dataCustomer ke variabel baru.
            //	$nama adalah data nama customer.
            //	$nohp adalah data nomor hp customer.
            //	$jenisKelamin adalah data jenis kelamin customer.
            //	$item adalah data berisi item dalam bentuk array berisikan item1, item2, dan item3.
            $nama_buah = $dataBuah[$i]['nama_buah']; // Contoh isi variabel: "Harry Pitter".
            $list_harga = $dataBuah[$i]['list_harga']; // Contoh isi variabel: "089977641321".
            $quantity = $dataBuah[$i]['quantity']; // Isi variabel: "L" atau "P".
            $bayaranAwalan = $dataBuah[$i]['bayarAwalan'];
            $diskon = $dataBuah[$i]['diskon'];
            $pembayaran_akhir = $dataBuah[$i]['pembayaran_akhir']; // Contoh isi variabel: ["1000", "2000", "500"]
            //echo $nama_buah;



            //	Baris untuk menampilkan data customer.
            echo "<tr>
            <td>" . $nama_buah . "</td> 
            <td>" . $list_harga . "</td> 
            <td>" . $quantity . "</td> 
            <td>" . $bayaranAwalan . "</td> 
            <td>" . $diskon . "</td> 
            <td>" . $pembayaran_akhir . "</td> 
            </tr>";
        }
        ?>
    </table>
</body>

</html>