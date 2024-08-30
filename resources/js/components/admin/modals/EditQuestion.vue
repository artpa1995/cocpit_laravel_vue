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
              <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Question</h3>
              <div class="mt-2">
                <form @submit.prevent="updateQuestion">
                  <div class="flex items-center gap-x-5">
                    <label>Question</label>
                    <textarea v-model="questionData.question" class="rounded-lg px-1 py-3 border border-gray-600" placeholder="Question"></textarea>
                  </div>
                  <div class="flex items-center gap-x-5 mt-5">
                    <label>Type</label>
                    <select v-model="questionData.type" class="rounded-lg px-5 py-3 border border-gray-600">
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
                    <label :class="{ 'checked': questionData.is_required }" class="my-cstm-checkbox">
                      <input type="checkbox" v-model="questionData.is_required">
                      <span class="my-cstm-check"></span>
                    </label>
                  </div>
                  <div class="flex items-start gap-x-5 mt-5">
                    <label class="mt-6">Responses</label>
                    <div class="mt-5">
                      <ul>
                        <li v-for="(response, index) in questionData.options" :key="response.id" class="mt-4">
                          <input type="text" class="rounded-lg px-5 py-3 border border-gray-600" placeholder="Add Response" @change="editOption(response.id, questionData.options[index].option)" v-model="questionData.options[index].option">
                          <a href="javascript:void(0)" @click="removeOption(index, response.id)" class="remove-option">×</a>
                        </li>
                      </ul>
                    
                      <button type="button" class="text-white bg-sky-900 rounded-lg px-5 py-3 mt-5" @click="addOption(questionData.id)">Add</button>
                    </div>
                  </div>
                  <button type="submit" class="text-white bg-sky-900 rounded-lg px-5 py-3 mt-5">Save</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="$emit('close-modal')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    showModal: {
      type: Boolean,
      required: true,
    },
    question: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      questionData: {
        ...this.question,
      },
    };
  },
  watch: {
    question(newQuestion) {
      this.questionData = { ...newQuestion };
    },
  },
  methods: {
    async editOption(question_id, value){

      console.log(question_id, value);
      try {
          const response = await axios.post(`/edit_option`, {'id': question_id, 'value' : value});
        } catch (error) {
          if (error.response) {
            console.log(` ${error.response.data.message}`);
          } else if (error.request) {
            console.log('No response received from server');
          } else {
            console.log(`Error: ${error.message}`);
          }
          console.error('Error fetching questions', error);
        }

    },
    async addOption(question_id) {

      try {
          const response = await axios.post(`/add_option`, {'id': question_id});
          this.questionData.options.push({ option: '', id : response.data.id});

          console.log(this.questionData.options);
        } catch (error) {
          if (error.response) {
            console.log(` ${error.response.data.message}`);
          } else if (error.request) {
            console.log('No response received from server');
          } else {
            console.log(`Error: ${error.message}`);
          }
          console.error('Error fetching questions', error);
        }

    },
    async removeOption(index, option_id) {
    
      try {
          const response = await axios.post(`/delete_option`, {'id': option_id});
          this.questionData.options.splice(index, 1);
        } catch (error) {
          if (error.response) {
            console.log(` ${error.response.data.message}`);
          } else if (error.request) {
            console.log('No response received from server');
          } else {
            console.log(`Error: ${error.message}`);
          }
          console.error('Error fetching questions', error);
        }

    },
    async updateQuestion() {
      try {
        const response = await axios.put(`/update_question/${this.questionData.id}`, this.questionData);
        if (response.data.success) {
          this.$emit('close-modal');
          this.$emit('question-updated');
        }
      } catch (error) {
        console.error('Error updating question', error);
        alert(`Error: ${error.message}`);
      }
    },
  },
};
</script>

