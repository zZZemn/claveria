<?php
include("check-expiration.php");
include("global-components/header.php");
$getAnnouncements = $db->getAnnouncement();
?>
<section class="backgound-image-section bg-dark">
    <img src="assets/CBTIMS.png" class="img-fluid">
    <div class="main-page-text">
        <h1 class="text-light">Claveria Bus Transport, Inc.</h1>
        <hr>
        <p>Your trusted partner in convenient and comfortable travel.</p>
    </div>
</section>

<!-- Add Book Now button -->
<section class="book-now-section text-center py-4">
    <button class="btn btn-primary btn-lg">Book Now</button>
</section>

<section class="about-section p-5 m-5 text-secondary card">
    <h2>About us</h2>
    <p>Welcome to Claveria Bus Transport, Inc., your trusted partner in convenient and comfortable travel. As a premier bus company, we take pride in connecting communities and providing safe journeys for our passengers. Claveria Bus Transport, Inc. is dedicated to delivering top-notch transportation services with a focus on reliability, safety, and customer satisfaction. With years of experience in the industry, we have become synonymous with quality travel on the Claveria to Laoag and Laoag to Claveria routes.</p>
    <p>At Claveria Bus Transport, safety is our utmost priority. Our team of experienced and skilled drivers is committed to providing a secure and pleasant travel experience. Our dedicated staff is always ready to assist you with any inquiries or concerns.</p>
    <p>We understand the importance of excellent customer service. Our friendly staff is here to assist you from ticket booking to arrival, ensuring that your experience with Claveria Bus Transport is seamless and enjoyable.</p>
</section>
<section class="announcement-section p-5 m-5 text-secondary card">
    <?php
    while ($announcement = $getAnnouncements->fetch_assoc()) {
        echo "<div style='height: 300px; width: 300px'>
            <img src='backend/announcement/" . $announcement['img'] . "'>
          </div>";
    }
    ?>
</section>
<?php
include("global-components/footer.php");
?>