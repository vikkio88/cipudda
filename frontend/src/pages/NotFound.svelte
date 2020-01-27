<script>
  const words = [
    "Minchia!",
    "Porca Troia!",
    "Mannaggia la miseria!",
    "Minchia Minchia..",
    "Ma che cazzo...",
  ];
  const word = words[Math.floor(Math.random() * words.length)];
</script>

<style>
  div.no-result {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
</style>

<div class="no-result">
  <h3>
    <strong>{word}</strong>
  </h3>
  Not found
</div>
