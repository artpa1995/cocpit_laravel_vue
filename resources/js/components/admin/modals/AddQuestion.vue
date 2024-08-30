<template>
  <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Add Question</h3>
              <div class="mt-2">
                <form @submit.prevent="add_question" >
                  <div class="flex items-center gap-x-5 ">
                    <label>Question</label>
                    <textarea v-model="question" class="rounded-lg px-1 py-3 border border-gray-600" type="text" placeholder="Question"> </textarea>
                  </div>

                  <div class="flex items-center gap-x-5 mt-5">
                    <label>Type</label>
                    <select v-model="question_type" class="rounded-lg px-5 py-3 border border-gray-600">
                      <option value="1">Multiple Choice</option>
                      <option value="2">Multiple Select</option>
                      <option value="3">Multi Select</option>
                      <option value="4">Checkbox</option>
                      <option value="5">Rank Selected</option>
                      <option value="6">Short text</option>
                      <option value="7">Long text</option>
                      <option value="8">Telephone Number</option>
                      <option value="9">Email</option>
                      <option value="10">Date</option>
                    </select>
                  </div>

                  <div class="flex items-center gap-x-5 mt-5">
                    <label>Required</label>
                    <label class="my-cstm-checkbox">
                      <input v-model="is_required" class=""  type="checkbox" value="1">
                      <span class="my-cstm-check"></span>
                    </label>
                  </div>

                  <div class="flex items-center gap-x-5 mt-5">
                    <label>Responses</label>
                    <ul>
                      <li v-for="(response, index) in responses" :key="index" class="ui-state-default">
                        <input type="text" class="rounded-lg px-5 py-3 border border-gray-600" placeholder="Add Response" v-model="responses[index]">
                        <a href="javascript:void(0)" @click="removeOption(index)" class="remove-option">×</a>
                      </li>
                    </ul>
                    <button type="button" class="text-white bg-sky-900 rounded-lg px-5 py-3" @click="addOption">Add</button>
                  </div>

                  <button type="submit" class="text-white bg-sky-900 rounded-lg px-5 py-3  mt-5" >Save</button>

                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="$emit('close-modal')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showModal: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      question: '',
      question_type: '1',
      is_required: 0,
      responses: ['']
    };
  },
  methods: {
    addOption() {
      this.responses.push('');

      console.log(this.responses);
    },
    removeOption(index) {
      this.responses.splice(index, 1);
    },
    add_question(){
      const formData = {
        'question' : this.question || '',
        'question_type' : this.question_type || '',
        'is_required' : this.is_required || 0,
        'responses' : this.responses || [],
      };

      axios.post('/add_question', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(response => {
          if(response.data.success){
            this.$emit('close-modal')
          }
         console.log(response.data.success);
        })
        .catch(error => {
            if (error.response) {
                alert(` ${error.response.data.message}`);
            } else if (error.request) {
                alert('No response received from server');
            } else {
                alert(`Error: ${error.message}`);
            }
            console.error('Error updating profile', error);
        });
    }
  }
};
</script>

<style scoped>

.remove-option {
  margin-left: 10px;
  cursor: pointer;
  color: red;
}
</style>
