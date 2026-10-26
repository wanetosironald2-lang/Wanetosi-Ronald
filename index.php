<?php require_once __DIR__ . '/includes/header.php';

$slides = $pdo->query("SELECT * FROM slider WHERE is_active=1 ORDER BY sort_order ASC, id DESC")->fetchAll();
$latestNews = $pdo->query("SELECT * FROM news WHERE is_published=1 ORDER BY created_at DESC LIMIT 3")->fetchAll();
?>

<?php if ($slides): ?>
<section class="slider">
  <?php foreach ($slides as $i => $s): ?>
  <div class="slide <?= $i===0?'active':'' ?>" style="background-image:url('<?= SITE_URL ?>/uploads/slider/<?= e($s['image']) ?>')">
    <div class="slide-overlay">
      <div class="container">
        <h2><?= e($s['title']) ?></h2>
        <p><?= e($s['subtitle']) ?></p>
        <?php if ($s['link']): ?><a class="btn" href="<?= e($s['link']) ?>">Learn More</a><?php endif; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <button class="slider-prev">&#10094;</button>
  <button class="slider-next">&#10095;</button>
</section>
<?php endif; ?>
<section class="section">
  <div class="container">
    
    <div class="welcome" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
      
      <img id="imageSlider" 
           src="<?= SITE_URL ?>/assets/uploads/logo.jpg" 
           alt="School Badge" 
           style="width: 50%; max-width: 400px; height: auto; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 15px 30px rgba(0,0,0,0.15); transition: opacity 0.3s ease;">
           
      <p style="font-size: 0.9rem; color: #666; margin-bottom: 30px;">
        <i class="fa fa-hand-pointer"></i> <em></em>
      </p>
      
      <h2 style="margin: 15px 0; font-size: 2.5rem; color: #1a237e;">WELCOME TO <?= e($schoolName) ?></h2>
      
      <p style="font-style: italic; font-weight: bold; color: #2e7d32; font-size: 1.5rem; margin-bottom: 25px;">
        HONESTY AND HARDWORK
      </p>
      
      <p style="max-width: 600px; line-height: 1.5; font-size: 1.1rem; color: #444;">
       <strong> We are committed to providing quality education that develops the whole student academically, morally and socially.<strong>
      </p>
      
      <div class="stats" style="margin-top: 40px; width: 100%; display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
        <div><h3>30+</h3><p>Years of Excellence</p></div>
        <div><h3>1200+</h3><p>Students</p></div>
        <div><h3>60+</h3><p>Qualified Teachers</p></div>
        <div><h3>98%</h3><p>Pass Rate</p></div>
      </div>
      
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2>Join Our Community</h2>
    <p>Applications for the next academic year are now open!</p>
    <a href="<?= SITE_URL ?>/apply.php" class="btn">Apply Online</a>
    <a href="<?= SITE_URL ?>/track-application.php" class="btn btn-outline">Track Application</a>
  </div>
</section>
<script>
  
  
  const images = [
    "<?= SITE_URL ?>/assets/uploads/logo.jpg",
    "<?= SITE_URL ?>/assets/uploads/block.jpg", 
    "<?= SITE_URL ?>/assets/uploads/registration.jpg",
    "<?= SITE_URL ?>/assets/uploads/results.jpg",
    "<?= SITE_URL ?>/assets/uploads/girl.jpg",
    "<?= SITE_URL ?>/assets/uploads/boys.jpg",
    "<?= SITE_URL ?>/assets/uploads/suspends.jpg",
    "<?= SITE_URL ?>/assets/uploads/sports.jpg"

  ];

  let currentIndex = 0;
  const sliderImg = document.getElementById('imageSlider');

  function nextImage() {
    sliderImg.style.opacity = 0.2;

    setTimeout(() => {
      currentIndex++;
      if (currentIndex >= images.length) {
        currentIndex = 0; 
      }
      
      sliderImg.src = images[currentIndex];
      
      sliderImg.style.opacity = 1;
    }, 300); 
  }

  setInterval(nextImage, 3000);
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
