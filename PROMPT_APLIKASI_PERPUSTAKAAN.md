# Prompt pembuatan aplikasi perpustakaan

Buat aplikasi web perpustakaan berbahasa Indonesia. Anggota perlu bisa menjawab dua pertanyaan dari halaman katalog: “Apakah buku ini tersedia?” dan “Di rak mana saya bisa menemukannya?” Petugas perlu bisa mencatat peminjaman dan pengembalian dari kode eksemplar yang tertera pada buku. Gunakan **biru sebagai warna primer** dan **pink sebagai warna sekunder**.

## Tema dan tampilan

| Warna | Kode | Penggunaan |
| --- | --- | --- |
| Biru primer | `#1D4ED8` | Tombol utama seperti **Simpan peminjaman**, tautan, dan penanda menu aktif. Gunakan teks putih pada tombol biru. |
| Pink sekunder | `#BE185D` | Teks dan garis tepi untuk label kategori buku. Gunakan pink muda `#FCE7F3` sebagai latar label. |
| Warna netral | `#FFFFFF`, `#F8FAFC`, `#1E293B` | Gunakan putih untuk formulir, abu-abu muda untuk latar halaman, dan teks gelap untuk judul serta isi. |

Simpan warna sebagai variabel CSS agar tema dapat diubah dari satu tempat. Tulis status dengan kata yang jelas, seperti **Tersedia**, **Dipinjam**, atau **Terlambat**. Pada ponsel, letakkan pencarian di atas daftar buku dan tampilkan jumlah tersedia dekat judul. Beri label pada setiap kolom formulir dan pastikan fokus terlihat saat pengguna berpindah dengan tombol Tab.

## Hak akses

| Peran | Tugas |
| --- | --- |
| Petugas | Mengelola judul, eksemplar, dan anggota. Mencatat peminjaman serta pengembalian dan melihat daftar pinjaman yang melewati jatuh tempo. |
| Anggota | Mencari buku, memeriksa lokasi dan ketersediaan, serta melihat pinjaman aktif, tanggal jatuh tempo, dan riwayat miliknya setelah masuk. |

Periksa peran dan kepemilikan data di server setiap kali pengguna membuka halaman atau mengirim formulir.

## Katalog dan aturan peminjaman

1. Pisahkan data judul dari eksemplar fisik. Simpan judul, penulis, kategori, dan ISBN jika ada. Beri setiap eksemplar kode inventaris unik serta lokasi rak. Sediakan pencarian berdasarkan judul atau penulis dan filter ketersediaan.
2. Pada formulir peminjaman, minta petugas memilih anggota aktif dan memasukkan kode eksemplar. Tampilkan judul dan tanggal jatuh tempo sebelum petugas menyimpan transaksi.
3. Jadikan **7 hari kalender** dan **3 eksemplar aktif per anggota** sebagai pengaturan awal yang bisa diubah. Simpan tanggal jatuh tempo pada saat peminjaman agar perubahan kebijakan berlaku untuk pinjaman berikutnya.
4. Catat satu pinjaman aktif per eksemplar. Jika dua petugas mencoba meminjamkan buku terakhir bersamaan, hanya satu transaksi boleh berhasil. Hitung ketersediaan katalog dari eksemplar yang benar-benar dapat dipinjam.
5. Saat buku kembali, cari pinjaman aktif melalui kode eksemplar, catat tanggal kembali, dan perbarui ketersediaan dalam satu transaksi basis data. Pertahankan riwayatnya. Jika petugas mengirim formulir dua kali, jumlah tersedia hanya bertambah satu.
6. Tandai pinjaman aktif sebagai **Terlambat** mulai hari setelah tanggal jatuh tempo. Di daftar petugas, tampilkan judul, anggota, dan tanggal jatuh tempo agar petugas tahu siapa yang perlu dihubungi.

## Implementasi dan hasil yang diminta

Gunakan hanya HTML, CSS, dan PHP untuk aplikasi. Semua fitur harus berjalan tanpa JavaScript, termasuk dari pustaka atau CDN. Gunakan formulir HTML dengan metode GET untuk pencarian judul atau penulis. Untuk penghapusan, tampilkan halaman konfirmasi berisi judul buku dan pilihan **Batal** atau **Ya, hapus buku**. Jalankan penghapusan hanya setelah PHP menerima dan memvalidasi konfirmasi melalui POST.

Jika proyek sudah tersedia, ikuti struktur serta teknologi yang digunakan dan pertahankan data katalog yang ada. Untuk proyek baru di Laragon, gunakan PHP dan MySQL atau MariaDB. Validasi masukan di server, gunakan kueri berparameter, dan simpan kata sandi sebagai hash. Sertakan skema atau migrasi basis data serta langkah singkat untuk menjalankan aplikasi dan mencoba kedua peran.

## Kriteria penerimaan

- [ ] Dengan JavaScript dinonaktifkan di browser, pengguna bisa mencari buku, menampilkan kembali semua judul, menambah dan mengubah buku, serta membatalkan atau mengonfirmasi penghapusan.
- [ ] Untuk satu judul dengan dua eksemplar tersedia, peminjaman satu eksemplar membuat katalog menampilkan **1 dari 2 tersedia**. Setelah dikembalikan, katalog menampilkan **2 dari 2 tersedia**.
- [ ] Dengan batas awal tiga pinjaman aktif, percobaan meminjam eksemplar keempat menampilkan alasan penolakan dan buku tetap tersedia.
- [ ] Pinjaman yang jatuh tempo pada 10 Mei tetap berstatus **Dipinjam** sepanjang 10 Mei dan menjadi **Terlambat** pada 11 Mei jika buku belum kembali.
- [ ] Anggota hanya dapat membuka riwayatnya sendiri, termasuk ketika mengganti ID anggota pada alamat halaman.
- [ ] Pada layar ponsel selebar 360 piksel, pengguna dapat mencari judul, membaca lokasi rak, dan melihat ketersediaan tanpa menggulir halaman ke samping. Tombol utama berwarna biru dan label kategori memakai aksen pink.
