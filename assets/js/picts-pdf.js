(function() {
  let currentPageIndex = 0;
  let pageMode = 1;
  let cursorIndex = Math.floor(currentPageIndex / pageMode);
  let pdfInstance = null;
  let totalPagesCount = 0;
  let zoomLevel = 100;

  const viewport = document.querySelector("#viewport");
  
  window.initPDFViewer = function(pdfURL) {
    pdfjsLib.getDocument(pdfURL).then(pdf => {
      pdfInstance = pdf;
      totalPagesCount = pdf.numPages;
      initPager();
      initZoom();
      initRollover();
      render();
    });
  };

  function onPagerButtonsClick(event) {
    const action = event.target.getAttribute("data-pager");
    
    //Adjust Zoom Levels
    if(zoomLevel != 100){
        const currentZoom = document.getElementById("zoomlevel");
        zoomLevel = 100;
        currentZoom.innerHTML = zoomLevel+'%';
    }
    

    if (action === "prev") {
      if (currentPageIndex === 0) {
        return;
      }
      currentPageIndex -= pageMode;
      if (currentPageIndex < 0) {
        currentPageIndex = 0;
      }
      render();
    }
    if (action === "next") {
      if (currentPageIndex === totalPagesCount - 1) {
        return;
      }
      currentPageIndex += pageMode;
      if (currentPageIndex > totalPagesCount - 1) {
        currentPageIndex = totalPagesCount - 1;
      }
      render();
    }
  }
  function initPager() {
    const pager = document.querySelector("#pager");
    pager.addEventListener("click", onPagerButtonsClick);
    return () => {
      pager.removeEventListener("click", onPagerButtonsClick);
    };
  }

  function onZoomButtonsClick(event) {
    const action = event.target.getAttribute("data-pager");
    const currentZoom = document.getElementById("zoomlevel");
    const canvas = document.getElementById("canvas");

    if (action === "zoomin") {
      if (zoomLevel < 200) {
        zoomLevel = zoomLevel + 20;
        currentZoom.innerHTML = zoomLevel+'%';
      }
    }

    if (action === "zoomout") {
      if (zoomLevel > 100) {
        zoomLevel = zoomLevel - 20;
        currentZoom.innerHTML = zoomLevel+'%';
      }
    }
    
    canvas.style.transform = "scale("+zoomLevel/100+")";
  }


  function initZoom() {
    const pager = document.querySelector("#zoom");
    pager.addEventListener("click", onZoomButtonsClick);
    return () => {
      pager.removeEventListener("click", onZoomButtonsClick);
    };
  }

  function initRollover() {
    const roll = document.getElementById("viewport");
    roll.addEventListener("mousemove", onRollover, false);
  }

    function onRollover(e) {
        const canvas = document.getElementById("canvas");
        const stage = document.getElementById("stage");
        var m_posx = 0, m_posy = 0, e_posx = 0, e_posy = 0, obj = this;
        
            //get mouse position on document crossbrowser
            if (!e){e = window.event;}
            if (e.pageX || e.pageY){
                m_posx = e.pageX;
                m_posy = e.pageY;
            } else if (e.clientX || e.clientY){
                m_posx = e.clientX + document.body.scrollLeft
                         + document.documentElement.scrollLeft;
                m_posy = e.clientY + document.body.scrollTop
                         + document.documentElement.scrollTop;
            }
            //get parent element position in document
            if (obj.offsetParent){
                do{ 
                    e_posx += obj.offsetLeft;
                    e_posy += obj.offsetTop;
                } while (obj = obj.offsetParent);
            }
            // mouse position minus elm position is mouseposition relative to element:
            var pos_x = m_posx-e_posx;
            var pos_y = m_posy-e_posy;
            
            //Canvas Height & Width
            var canvas_x = Math.round(canvas.getBoundingClientRect().width);
            var canvas_y = Math.round(canvas.getBoundingClientRect().height);

            //Viewport Height & Width
            var stage_x = Math.round(stage.offsetWidth);
            var stage_y = Math.round(stage.offsetHeight);
            
            //Difference
            var diff_x = Math.round(canvas_x - stage_x);
            var diff_y = Math.round(canvas_y - stage_y);
            
            // console.log("Canvas X: "+canvas_x+"px, View X: "+stage_x+"px, diff_x : "+diff_x+"px");
            // console.log("Canvas Y: "+canvas_y+"px, View Y: "+stage_y+"px, diff_y : "+diff_y+"px");

            //Mouse Percent Across Viewport
            var mouse_percent_x = pos_x / canvas_x;
            var mouse_percent_y = pos_y / canvas_y;
            
            //Actually Move the Convas 
            var canvasXmove = Math.round(diff_x * mouse_percent_x);
            var canvasYmove = Math.round(diff_y * mouse_percent_y);
            
            // console.log("X : "+canvasXmove+"px");
            // console.log("Y : "+canvasYmove+"px");

            canvas.style.transform = ("scale("+zoomLevel/100+") translate("+ -canvasXmove+"px,"+ -canvasYmove+"px)");

    }

    function render() {
        cursorIndex = Math.floor(currentPageIndex / pageMode);
        const startPageIndex = cursorIndex * pageMode;
        const endPageIndex =
          startPageIndex + pageMode < totalPagesCount
            ? startPageIndex + pageMode - 1
            : totalPagesCount - 1;
    
        const renderPagesPromises = [];
        
        const currentPage = document.getElementById("currentPage");
        const totalPages = document.getElementById("totalPages");
    
        currentPage.innerHTML = currentPageIndex + 1;
        totalPages.innerHTML = totalPagesCount;
    
        for (let i = startPageIndex; i <= endPageIndex; i++) {
          renderPagesPromises.push(pdfInstance.getPage(i + 1));
        }
    
        Promise.all(renderPagesPromises).then(pages => {
          const pagesHTML = '<div id="stage"><canvas id="canvas"></canvas></div>'.repeat(pages.length);
          viewport.innerHTML = pagesHTML;
          pages.forEach(renderPage);
        });
    }

  function renderPage(page) {
    let pdfViewport = page.getViewport(1);

    const container =
      viewport.children[page.pageIndex - cursorIndex * pageMode];
    pdfViewport = page.getViewport(container.offsetWidth / pdfViewport.width);
    const canvas = container.children[0];
    const context = canvas.getContext("2d");
    canvas.height = pdfViewport.height;
    canvas.width = pdfViewport.width;

    page.render({
      canvasContext: context,
      viewport: pdfViewport
    });
    
  }
})();
