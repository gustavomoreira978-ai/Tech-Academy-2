document.addEventListener("DOMContentLoaded", () => {
  const mainImage = document.querySelector("#imagemProdutoPrincipal");
  const modalImage = document.querySelector("#imagemProdutoModal");
  const thumbs = document.querySelectorAll(".thumb-produto");
  const quantityInput = document.querySelector("#quantidadeProduto");

  thumbs.forEach((thumb) => {
    thumb.addEventListener("click", () => {
      const image = thumb.dataset.image;

      if (mainImage && image) {
        mainImage.src = image;
      }

      if (modalImage && image) {
        modalImage.src = image;
      }

      thumbs.forEach((item) => item.classList.remove("active"));
      thumb.classList.add("active");
    });
  });

  document.querySelectorAll("[data-qty-action]").forEach((button) => {
    button.addEventListener("click", () => {
      if (!quantityInput) {
        return;
      }

      const current = Number(quantityInput.value) || 1;
      const min = Number(quantityInput.min) || 1;
      const max = Number(quantityInput.max) || 10;
      const next = button.dataset.qtyAction === "plus" ? current + 1 : current - 1;

      quantityInput.value = Math.min(max, Math.max(min, next));
    });
  });
});
