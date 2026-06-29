<?php
// inc/footer.php
?>
  </main>

  <footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <h5>Tigray Volleyball Federation</h5>
          <p>Promoting excellence in volleyball across Tigray.</p>
          <div>
            <a href="#" class="text-white me-2" title="Facebook">f</a>
            <a href="#" class="text-white me-2" title="Twitter">𝕏</a>
            <a href="#" class="text-white" title="Instagram">📷</a>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <h5>Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
            <li><a href="/events.php" class="text-white-50 text-decoration-none">Events</a></li>
            <li><a href="/teams.php" class="text-white-50 text-decoration-none">Teams</a></li>
            <li><a href="/news.php" class="text-white-50 text-decoration-none">News</a></li>
            <li><a href="/contact.php" class="text-white-50 text-decoration-none">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-4">
          <h5>Newsletter</h5>
          <form method="post" action="/subscribe.php">
            <div class="input-group mb-2">
              <input type="email" name="email" class="form-control" placeholder="Your email" required>
              <button class="btn btn-primary" type="submit">Subscribe</button>
            </div>
          </form>
          <p class="text-white-50 small"><a href="/privacy.php" class="text-white-50">Privacy</a> | <a href="/terms.php" class="text-white-50">Terms</a></p>
        </div>
      </div>
      <div class="border-top pt-3 mt-3 text-center text-white-50">
        <p>&copy; 2024 Tigray Volleyball Federation. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
