# Yazılım Geliştirme Yönetimi Sistemi

Bu sistem, PHP, MySQL, HTML, CSS ve Bootstrap teknolojileri kullanılarak geliştirilmiş bir yazılım geliştirme yönetimi uygulamasıdır. Kullanıcıların kendi projelerini yönetmelerini, diğer kullanıcılara görev atamalarını ve projeler üzerinde düzenlemeler yapmalarını sağlar.

## Özellikler

- Kayıt olma ve giriş ekranı
- Kullanıcı bazında proje ekleme, düzenleme, silme
- Projelere diğer kullanıcıları görev olarak atama

## Kurulum

1. Bu projeyi GitHub üzerinden indirin.
2. Bilgisayarınıza [XAMPP](https://www.apachefriends.org/index.html) kurun ve çalıştırın.
3. `config.php` dosyasında veritabanı bağlantı ayarlarını yapın:
   - `$servername` - Sunucu adı
   - `$username` - Veritabanı kullanıcı adı
   - `$password` - Veritabanı şifresi
   - `$dbname` - Veritabanı adı
4. PHPMyAdmin üzerinden `ygys_veritabani` adında bir veritabanı oluşturun.
5. `vgys_veritabani.sql` dosyasını içe aktararak veritabanı tablolarınızı oluşturun.
6. Projeyi bir web sunucusunda veya XAMPP üzerinde yerel bir sunucuda çalıştırın.

## Kullanım

1. Ana sayfadan giriş yapın veya yeni bir hesap oluşturun.
2. Projelerinizi görüntüleyin, yeni projeler ekleyin, mevcut projeleri düzenleyin veya silin.
3. Görevleri görüntüleyin ve projelerinizde diğer kullanıcılara görevler atayın.

### Site Linki

Projeye [buradan](http://ygys.infinityfreeapp.com) ulaşabilirsiniz.

## Katkıda Bulunma

Projeye katkıda bulunmak isteyenler için pull request'ler kabul edilmektedir. İyileştirme ve hata düzeltmeleriniz için öncelikle bir issue açmanızı tavsiye ederim.




