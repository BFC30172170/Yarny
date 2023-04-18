<div class="fixed bottom-4 right-4 w-96 z-10 transition-all duration-300">
  <div class="relative w-full h-36">
    <!-- Render all messages -->
    <template x-for="message, index in $store.main.messages" class="transition-all duration-300">

      <div
        :style="`bottom: ${index * 100}px !important;`"
        :class="message.status == 'success' ? 'bg-emerald-200 font-bold absolute w-full p-4 flex space-between rounded-lg transition-all duration-300' : 'bg-red-200 font-bold absolute w-full p-4 flex space-between rounded-lg transition-all duration-300'">
        <hr />
        <div x-text="message.message"></div>
        <button @click="$store.main.deleteMessage(index)" class="ml-auto">x</button>
      </div>
    </template>
  </div>
</div>
</main>
<!-- Footer Content -->
<footer
  class="flex w-full bg-teal-400 text-white gap-4 p-8 text-xl font-black uppercase mt-auto">Copyright © 2023 YARNY</footer>


<!-- Client side notifcations -->
<script>

  document.addEventListener("alpine:init", () => {

    Alpine.store("main", {
      // The array of all messages, set to session messages on load,
      // so that server side messages on page reload/redirect are not lost in the client.
      messages: <?= json_encode($_SESSION['messages']) ?>,

      // Add a message and kill it after 15 secs
      addMessage(status, message) {
        let id = Date.now()
        this.messages.unshift({ id, status, message });

        setTimeout(() => {
          this.messages = this.messages.filter(function (message) {
            return message.id !== id;
          });
        }, 15000);
      },

      // Given an index, removes the message from the array
      deleteMessage(index) {
        this.messages = this.messages.filter((_, i) => i !== index);
      },
    });
  });

</script>
</body>

</html>

<!-- Clear out session messages after page load so these do not persist -->
<?php $_SESSION['messages'] = array() ?>