      </div>
		</div>
    <script>
      setTimeout(() => {
          const box = document.querySelector('.notification');
          if (box) {
              box.style.opacity = '0';
              setTimeout(() => box.style.display = 'none', 500);
          }
      }, 5000);
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    
  </body>
</html>