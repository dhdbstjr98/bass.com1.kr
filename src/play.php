<?php
include("./common.php");

$no = (int)$_GET['no'];

if(!$no) {
  exit("no no");
}

$sheet = sql_fetch("SELECT * FROM `sheet` WHERE no = '$no'");
if(!$sheet) {
  exit("no data");
}

$pages = sql_fetch_all("SELECT * FROM `page` WHERE sheet_no = '$no'");

$acc = $sheet['start_delay'];
foreach($pages as $idx => $page) {
  $pages[$idx]['start_at'] = $acc;
  $acc = $acc + $page['beat'] * 60 * 1000 / $sheet['beat_speed'] + $page['delay'];
}

$page_title = $sheet['title'] . ' - ' . $sheet['artist'] . ' (' . $sheet['source'] . ')';
?>

<!doctype html>
<html>
<head>
  <title><?php echo $page_title; ?></title>
  <meta charset="UTF-8">
  <style>
    .container { width: 1024px; margin: 0 auto; }
    #title { font-size:1.5em; font-weight: bold; }
    #pages { margin-top:20px; height: 600px; overflow-y:scroll; text-align: center; }
    #audio-wrapper { margin-top:20px; position:relative; }
    #audio { width:80%; }
    #input-speed { width: 7%; position:absolute; right:10%; height: 100%; text-align:center; box-sizing:border-box; }
    #btn-play { width:7%; position:absolute; right:0; height:100%; border:1px solid #000; border-radius:10px; background-color:#fff; color:#000; }
  </style>
</head>
<body>
  <div class="container">
    <div id="title">
      <?php echo $page_title; ?>
    </div>
    <div id="pages">
      <?php foreach($pages as $page) { ?>
        <img src="/data/image/<?php echo $page['image_url'] ?>" data-start-at="<?php echo $page['start_at'] ?>" />
      <?php } ?>
    </div>
    <div id="audio-wrapper">
      <audio controls id="audio">
        <source src="/data/audio/<?php echo $sheet['audio_url'] ?>" />
      </audio>
      <input id="input-speed" value="1.0">
      <button id="btn-play">play</button>
    </div>
  </div>
  <script>
    const audio = document.getElementById("audio");
    const pages = <?php echo json_encode($pages); ?>;

    const findCurrentPage = (currentTime) => {
      const currentMs = currentTime * 1000;

      let left = 0;
      let right = pages.length - 1;
      let result = null;

      while (left <= right) {
        const mid = Math.floor((left + right) / 2);
        const startAt = Number(pages[mid].start_at);

        if (startAt === currentMs) {
          return mid;
        } else if (startAt < currentMs) {
          result = mid;
          left = mid + 1;
        } else {
          right = mid - 1;
        }
      }

      return result;
    }

    const beep = () => { 
      var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");
      snd.play(); 
    }

    const delayedStart = async () => {
      audio.pause();
      audio.currentTime = document.getElementById("pages").children[0].dataset['startAt'] / 1000;
      document.getElementById("pages").scrollTop = 0;
      const speed = parseFloat(document.getElementById("input-speed").value)

      for(let i = 0; i < <?php echo $sheet['beat']; ?>; i++) {
        beep();
        await new Promise(res => setTimeout(res, 1000 / <?php echo $sheet['beat_speed']; ?> * 60 / speed));
      }

      audio.play();
    }

    document.getElementById("title").addEventListener("click", delayedStart);
    document.getElementById("btn-play").addEventListener("click", delayedStart);

    const AUTO_SCROLL_THRESHOLD = 500
    let autoScrollStartAt = 0;
    let autoScrollEnabeld = true;
    let autoScrollEnabeldDebounce;
    let lastPageIdx = 0;

    document.getElementById("pages").addEventListener("scroll", (e) => {
      const now = Date.now();
      const isTriggeredByAutoScroll = now - autoScrollStartAt < AUTO_SCROLL_THRESHOLD
      if(isTriggeredByAutoScroll) {
        return;
      }

      clearTimeout(autoScrollEnabeldDebounce);
      autoScrollEnabeld = false;
      autoScrollEnabeldDebounce = setTimeout(() => {
        autoScrollEnabeld = true;
      }, 3000);
    });

    audio.addEventListener("timeupdate", () => {
      if(!autoScrollEnabeld) {
        return;
      }

      const currentPageIdx = findCurrentPage(audio.currentTime);
      if(lastPageIdx !== currentPageIdx) {
        autoScrollStartAt = Date.now();
        document.getElementById("pages").children[currentPageIdx].scrollIntoView({ block: 'start', behavior: 'smooth' });
        lastPageIdx = currentPageIdx;
      }
    });

    Array.from(document.getElementById("pages").children).forEach((el) => {
      el.addEventListener("click", () => {
        audio.currentTime = el.dataset.startAt / 1000;
        el.scrollIntoView({ block: 'start', behavior: 'smooth' });
      });
    });

    document.getElementById("input-speed").addEventListener("change", (e) => {
      audio.playbackRate = parseFloat(e.target.value);
    });
  </script>
</body>
</html>
