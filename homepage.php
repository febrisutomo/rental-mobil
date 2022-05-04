 <!-- hero section  -->
 <section id="hero" class="d-flex flex-column justify-content-center">
   <div class="container">
     <div class="row align-items-center">
       <div class="col-lg-5">
         <h2 data-aos="fade-up">Rent the best car for any occasion an do it safely</h2>
         <p data-aos="fade-up" data-aos-delay="400">
           Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel adipisci animi numquam beatae? Optio numquam impedit consequuntur, maxime neque illum.
         </p>
         <a href="#cars" class="btn btn-primary" data-aos="fade-up" data-aos-delay="800">Find Car</a>
       </div>
       <div class="col-lg-7 d-flex justify-content-end pt-2" data-aos="fade-right" data-aos-delay="200">
         <img src="src/img/hero.png" class="img-fluid animated" width="90%" alt="hero-img">
       </div>
     </div>
   </div>
 </section>

 <!-- Cars Section  -->
 <section id="cars" class="cars">
   <div class="container" data-aos="fade-up">
     <div class="section-title">
       <h2>Choose Your Awesome Car</h2>
     </div>
     <div class="row" data-aos="fade-up" data-aos-delay="100">
       <div class="col-lg-12 d-flex justify-content-center">
         <ul id="cars-flters">
           <li data-filter="*" class="filter-active">All</li>
           <li data-filter=".filter-1">Sedan</li>
           <li data-filter=".filter-2">SUV</li>
           <li data-filter=".filter-3">MPV</li>
         </ul>
       </div>
     </div>
     <div class="row cars-container" data-aos="fade-up" data-aos-delay="200">
       <?php foreach ($cars as $car) : ?>
         <div class="col-lg-3 col-md-4 col-6 cars-item filter-<?= $car['id_jenis']; ?>">
           <div class="card">
             <img class="p-2" src="src\img\mobil\<?= $car['gambar']; ?>">
             <div class="card-body container-fluid">
               <h5><?= $car['nama_mobil']; ?></h5>
               <div><?= $car['transmisi']; ?></div>
               <h6 class="text-primary">Rp<?= $car['harga']; ?>K/day</h6>
               <?php if (isset($_SESSION['login']) && $_SESSION['login'] == 'user') {
                  $id_user = $_SESSION['id'];
                  $koneksi = mysqli_connect('localhost', 'root', '', 'rental_mobil');
                  $sql_active = mysqli_query($koneksi, "CALL userActiveRent($id_user)");
                  $active = mysqli_fetch_assoc($sql_active);
                } ?>
                <?php if(isset($active) && !is_null($active)):?>
                  <a href="?page=profil" onclick = "alert('Anda sedang melakukan booking atau rental!')" class="btn btn-primary">Select Car</a>
                <?php else: ?>
                  <a href="?page=rental&id=<?= $car['id_mobil'];?>" class='btn btn-primary'>Select Car</a>
                <?php endif; ?>
             </div>
           </div>
         </div>
       <?php endforeach; ?>
     </div>
   </div>
 </section>



 <!-- about section  -->
 <section id="about">
   <div class="container">
     <div class="row">
       <div class="col-xl-6">
         <img src="src/img/pajero.png">
       </div>
       <div class="col-xl-6">
         <div class="section-title justify-content-start">
           <h2>About Us</h2>
         </div>
         <p>
           Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore inventore eligendi culpa exercitationem illum sapiente enim nostrum ipsa et. Officia corporis nisi non repellendus.
         </p>
         <div class="features">
           <div>
             <i class="bx bx-car"></i>
             <h5>Variety of Car Brands</h5>
             <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure nostrum pariatur, dolores voluptate qui eum.</p>
           </div>
           <div>
             <i class="bx bx-support"></i>
             <h5>Awesome Customer Support</h5>
             <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit laborum alias rem cupiditate illum ex?</p>
           </div>
           <div>
             <i class="bx bx-check-shield"></i>
             <h5>Your Best Security</h5>
             <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum ipsum incidunt dolor inventore totam excepturi?</p>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>

 <section id="contact" class="contact">
   <div class="container">
     <div class="section-title">
       <h2>Contact Us</h2>
     </div>
     <div class="row mt-1">
       <div class="col-lg-4">
         <div class="info">
           <div class="address">
             <i class="bx bx-map"></i>
             <h4>Location:</h4>
             <p>Purwokerto, Indonesia</p>
           </div>
           <div class="email">
             <i class="bx bx-envelope"></i>
             <h4>Email:</h4>
             <p>febrisutomo@gmail.com</p>
           </div>
           <div class="phone">
             <i class="bx bx-phone"></i>
             <h4>Call:</h4>
             <p>+62 8587 0000 5110</p>
           </div>
         </div>
       </div>
       <div class="col-lg-8 mt-5 mt-lg-0">
         <form action="" method="post" role="form" class="php-email-form">
           <div class="form-row">
             <div class="col-md-6 form-group">
               <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required />
             </div>
             <div class="col-md-6 form-group">
               <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required />
             </div>
           </div>
           <div class="form-group">
             <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required />
           </div>
           <div class="form-group">
             <textarea class="form-control" name="message" placeholder="Type Your Message" rows="5" required></textarea>
           </div>
           <div class="text-center"><button type="submit" class="btn btn-primary">Send Message</button></div>
         </form>
       </div>
     </div>
   </div>
 </section>