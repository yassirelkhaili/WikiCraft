<main class="pt-32 pb-16 lg:pt-16 lg:pb-24 antialiased">
  <?php if(isset($wiki[0])): ?>
    <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
      <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
          <header class="mb-4 lg:mb-6 not-format">
              <address class="flex items-center mb-6 not-italic">
                  <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                      <img class="mr-4 w-16 h-16 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Jese Leos">
                      <div>
                          <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white"><?= $wiki[0]['author'] ?></a>
                          <p class="text-base text-gray-500 dark:text-gray-400">Category: <?= $wiki[0]['category'] ?></p>
                          <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="<?= substr($wiki[0]['created_at'], 0, 10) ?>">Created at: <?= $wiki[0]['created_at'] ?></time></p>
                          <?php if (!is_null($wiki[0]['edited_at'])): ?>
                            <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="<?= substr($wiki[0]['edited_at'], 0, 10) ?>">Edited at: <?= $wiki[0]['edited_at'] ?></time></p>
                          <?php endif ?>
                      </div>
                  </div>
              </address>
              <h1 class="mb-4 text-6xl font-extrabold leading-tight text-white lg:mb-6 lg:text-4xl"><?= $wiki[0]['title'] ?></h1>
          </header>
          <p class="lead text-gray-500 text-[1.2rem]"><?= $wiki[0]['content'] ?></p>
      </article>
  </div>
  <?php else: ?>
    <div class="w-full flex justify-center items-center">
    <h1 class="mb-4 text-6xl font-extrabold leading-tight text-[#3C82F5] lg:mb-6 lg:text-4xl">Wiki not found</h1>
    </div>
    <?php endif ?>
</main>