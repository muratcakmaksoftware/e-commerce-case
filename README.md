### Information
- **Laravel Framework Version:** 9.9.0
- **PHP Version:** 8.1.4
- **POSTMAN** https://documenter.getpostman.com/view/14752307/Uyr8kxhV
### Installation

Boş bir **ecommerce_case** adında database oluşturun ve aşağıdaki kodları çalıştırın.
```
php artisan migrate
php artisan db:seed
```

## About

- Case olduğundan dolayı hızlı anlaşılması açısından kodların çoğunda açıklamalar mevcuttur.
- İlk önce tüm senaryo üzerine veritabanı tasarımı çıkarılıp daha sonrasında yazılmıştır.
- İstenilen veri doldurmak için **seed/faker** kullanılmıştır ve ödeme sistemi içinde **Queue** kullanılmıştır
- Schedule kullanılarak her gece saat 03:00 de ödeme var mı kontrolü için **command** yazılmıştır.
- Kuyruk çalıştırmak için : **php artisan queue:work --queue=company_payments** 
- Kuyruk **Local** ortamında supervisord ile çalışmadığı için fail oluşumda tekrarlama olmayacaktır. Kuyruk ödeme kısmında fail oluşumunda kısmını test ederken tekrar kuyruğu çalıştırmalısınız. Tekrar denemeyi görebilmeniz için ek olarak release() 'de kullanılmıştır.

### Design Patterns
- Repository Design Pattern
- Strategy Design Pattern

### Database Design
![ecommerce db design!](public/images/db-design.png "ecommerce db design")

---

### Case

Proje için;\
Başlıkların hepsini veya;
- Yalnızca API
- Yalnızca Worker
- API + Callback
- Worker + Callback
- API + Worker

#### TANIM
E-Ticaret altyapısı sunan bir platform için mağaza, paket ve ödeme kayıtları API üzerinden kayıt yapılacaktır. Bu kayıtlar üzerinden aylık veya yıllık periyotlara göre paket tanımlamaları olacaktır. Bu paketler mağazanın sisteme kayıt olduğu tarih ile ilişkilendirilerek paket periyoduna göre ödemeleri Worker ile çekilecektir. Mağazada herhangi bir değişiklik olması durumunda belirlenen Endpoint’e Callback ile dönüş sağlanacaktır.

Tablolar: Companies, Packages, Company_packages, Company_payments Tablolar oluşturulduktan sonra Dummy (laravel seed/faker) veriler ile doldurmanız beklenmektedir.

#### API

**Company Register**\
Bir kullanıcı sisteme kayıt olmak istediğinde Request datası olarak “site_url, name, lastname, company_name, email, password” gönderecektir. Response olarak status, token ve company_id dönüşü yapmanız beklenmektedir.

**Company Package**\
Company belirlenen paketler doğrultusunda aylık veya yıllık yenilenecek şekilde paket tanımlaması yapmanız beklenmektedir. Company paket tanımlama işleminde request olarak company_id, package_id gönderilecektir. Response olarak status,start_date, end_date, package bilgileri dönmenizi bekliyoruz.

**Check Company Package**\
Gerekli görüldüğünde token üzerinden company ve package bilgileri talep edileceği bir endpoint oluşturmanız beklenmektedir.

#### WORKER

- Cron’dan ya da supervisord gibi çeşitli server side tetikleyiciler vasıtası ile paket günü biten müşterilerin hesaplarından para çekimi yapılmak istenmektedir. Random bir hash oluşturarak son basamağı tek ise hesaptan çekildi, çift ise çekilemedi, şeklinde yapabilirsiniz.

- Çekilemez ise 1 gün ara ile tekrar denenecek şekilde bir kuyruk yapısı kullanmanız gerekiyor. Üçüncü seferde yapılamaz ise company pasif durumuna almanız gerekiyor.
Company Payments’ a denemeleri kayıt etmeniz beklenmektedir.

Worker işlemi için Queue kullanmanız beklenmektedir.

#### CALLBACK

Api veya Worker kısmında herhangi bir değişiklik olması durumunda belirlenen endpoint’e istek atması beklenmektedir.

#### RAPOR (İsteğe Bağlı)
Worker çalıştıktan sonra başarılı işlem, başarısız işlem, başarılı işlem tutarı, başarısız işlem tutarı ve günlere göre listeleme yapmalısınız

#### TEKNİK KOŞULLAR
- PHP 7.3 ve üzeri desteklemelidir.
- Tercihen Laravel 7 veya üstü kullanılmalıdır.
- Her company’nin bir adet paket tanımlaması olmalıdır.
- DB şeması, sql dosyası olarak verilmelidir.
- DB tablolarının özellikle company tablosunun milyonlarca kayıt altında çalışması beklenmektedir.

