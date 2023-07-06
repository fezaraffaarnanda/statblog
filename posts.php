<?php
  include("path.php");
  include(ROOT_PATH . "/app/controllers/topics.php");

  $posts = array();
  $postsTitle = 'Postingan';
  $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
  if (isset($keyword)) {
    if($keyword == ""){
      $postsTitle = "Postingan";
      $posts = getPublishedPosts();
    }else{
      $postsTitle = "Anda mencari '" . $keyword . "'";
      $posts = searchPosts($keyword);
    }
    $postsTitle = "Anda mencari '" . $keyword . "'";
    $posts = searchPosts($keyword);
  } else {
    $posts = getPublishedPosts();
  }
  $postsTitle = "Postingan";
?>
        <h1 class="recent-post-title"><?php echo $postsTitle ?></h1>
        <?php foreach ($posts as $post): ?>
          <div class="post clearfix">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="post-image">
            <div class="post-preview">
              <h2><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
              <i class="far fa-user"> <?php echo $post['username']; ?></i>
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
              <p class="preview-text">
                <?php echo html_entity_decode(substr($post['body'], 0, 150) . '...'); ?>
              </p>
              <a href="single.php?id=<?php echo $post['id']; ?>" class="btn read-more">Baca</a>
            </div>
          </div>    
        <?php endforeach; ?>