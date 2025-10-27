function activateProductSlider() {
    const productGroups = document.querySelectorAll('.productDimension');
  
    productGroups.forEach(group => {
      const navigation_links = group.querySelectorAll('.dimensionSliderNav');
      const image_slide = group.querySelectorAll('.productDimensionSliderImages');
  
      navigation_links.forEach((link, i) => {
        link.onclick = () => {
          activateSlider(navigation_links, i);
          activateSlider(image_slide, i);
        };
      });
  
      // Initialize first active
      activateSlider(navigation_links, 0);
      activateSlider(image_slide, 0);
    });
  
    function activateSlider(arr, i) {
      arr.forEach((el, index) => {
        el.classList.toggle('active', index === i);
      });
    }
  }
  
  window.addEventListener('load', activateProductSlider);