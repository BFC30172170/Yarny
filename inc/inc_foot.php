
<?=var_dump($_SESSION['messages'])?>
<div class="fixed bottom-4 right-4 w-96 z-10 transition-all duration-300">
    <div class="relative w-full h-36 bg-red-200">
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
<footer 
class="flex w-full bg-teal-400 text-white gap-4 p-8 text-xl font-black uppercase mt-auto">Copyright © 2021 Simple Website Template</footer>


<script>

    document.addEventListener("alpine:init", () => {
      
        Alpine.store("main", {
  // The array of all messages
  messages: <?=json_encode($_SESSION['messages'])?>,

  // The next message to add, its value is bound to the textarea field
  newMessage: "",

  // Adds the current value of `newMessage` to the array of messages
  addMessage(status,message) {
    let id = Date.now()
    this.messages.unshift({id,status,message});

    setTimeout(() => {
        this.messages = this.messages.filter(function( message) {
        return message.id !== id;
        });
    }, 15000);
  },

  // Given an index, changes the capitalization of the message to lower case
  lowerCaseMessage(index) {
    this.messages[index] = this.messages[index].toLowerCase();
  },

  // Given an index, changes the capitalization of the message to upper case
  upperCaseMessage(index) {
    this.messages[index] = this.messages[index].toUpperCase();
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

<!-- Clear out session messages after page load -->
<?php $_SESSION['messages'] = array()?>