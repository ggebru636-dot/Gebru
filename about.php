<?php
// about.php (About page - mission, history, leadership)
require_once __DIR__ . '/inc/db.php';
$page_title = 'About Us';
require_once __DIR__ . '/inc/header.php';
?>

<div class="container my-5">
  <h1>About the Tigray Volleyball Federation</h1>

  <!-- Mission & Vision -->
  <div class="row mt-5">
    <div class="col-md-6 mb-4">
      <h2>Our Mission</h2>
      <p>To promote, develop, and elevate volleyball in Tigray by fostering excellence, unity, and community engagement through competitive and recreational opportunities.</p>
    </div>
    <div class="col-md-6 mb-4">
      <h2>Our Vision</h2>
      <p>To establish Tigray as a leading volleyball region in East Africa, producing world-class athletes, coaches, and referees while building a vibrant volleyball culture.</p>
    </div>
  </div>

  <!-- History -->
  <section class="mt-5 mb-5 p-4 bg-light rounded">
    <h2>Our History</h2>
    <p>The Tigray Volleyball Federation was established in 1995 with a mission to organize, regulate, and promote volleyball in the Tigray region. Over nearly three decades, we have grown from a small local organization to a leading sports federation.</p>
    <ul>
      <li><strong>1995:</strong> Federation founded with 5 teams</li>
      <li><strong>2000:</strong> Hosted first regional championship</li>
      <li><strong>2010:</strong> Expanded youth development programs</li>
      <li><strong>2015:</strong> Built new training facility in Mekelle</li>
      <li><strong>2020:</strong> Launched online platform for member management</li>
      <li><strong>2024:</strong> Achieved 50+ registered teams and 2,000+ active members</li>
    </ul>
  </section>

  <!-- Leadership & Board -->
  <section class="mt-5">
    <h2>Board & Leadership</h2>
    <div class="row">
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
            <span style="color:#999;">Photo</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Dr. Gebremariam Tekle</h5>
            <p class="card-text"><strong>President</strong></p>
            <p class="card-text"><small>With 25 years of sports management experience, leading the federation since 2015.</small></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
            <span style="color:#999;">Photo</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Almaz Hailu</h5>
            <p class="card-text"><strong>Vice President</strong></p>
            <p class="card-text"><small>Tournament organizer and former national team coach with 20+ years experience.</small></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
            <span style="color:#999;">Photo</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Yohannes Tekle</h5>
            <p class="card-text"><strong>Secretary General</strong></p>
            <p class="card-text"><small>Handles federation operations and member services since 2018.</small></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
            <span style="color:#999;">Photo</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Tigist Abebe</h5>
            <p class="card-text"><strong>Treasurer</strong></p>
            <p class="card-text"><small>Financial management and budget oversight for federation activities.</small></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
            <span style="color:#999;">Photo</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Amare Desta</h5>
            <p class="card-text"><strong>Technical Director</strong></p>
            <p class="card-text"><small>Oversees coaching, training programs, and athlete development.</small></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div style="width:100%; height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;">
            <span style="color:#999;">Photo</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Abeba Gebre</h5>
            <p class="card-text"><strong>Referee Coordinator</strong></p>
            <p class="card-text"><small>Manages referee development, certification, and match assignments.</small></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Achievements -->
  <section class="mt-5 p-4 bg-light rounded">
    <h2>Key Achievements</h2>
    <ul>
      <li>Organized 15+ regional and national championships</li>
      <li>Trained 200+ certified coaches and referees</li>
      <li>Developed 50+ youth development programs</li>
      <li>Produced 5 national team players</li>
      <li>Built and maintained 3 volleyball courts</li>
      <li>Growing membership from 500 (1995) to 2,000+ (2024)</li>
    </ul>
  </section>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
