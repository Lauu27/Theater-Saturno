document.addEventListener("DOMContentLoaded", () => {

  const loadComponent = async (selector, htmlPath, cssPath) => {
    const element = document.querySelector(selector);
    if (!element) return;

    try {
      const response = await fetch(htmlPath);
      if (!response.ok) throw new Error(`Error al cargar ${htmlPath}`);
      element.innerHTML = await response.text();

      if (cssPath) {
        const link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = cssPath;
        document.head.appendChild(link);
      }

    } catch (err) {
      console.error(err);
    }
  };

  loadComponent(
    "footer",
    "/components/footer/footer.html",
    "/components/footer/footer.css"
  );

});
