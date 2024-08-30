<template>
    <div >
        <h1>Questions</h1>
        <button class="text-white bg-sky-900 rounded-lg px-5 py-3 " @click="showAddModal = true" >Add Question</button>
        <AddQuestion 
            :show-modal="showAddModal"
            @close-modal="showAddModal = false"
        />
        <div v-if="questions.length > 0">
          <ul>
        <li v-for="question in questions" :key="question.id" @click="editQuestion(question.id)">
          <div>
            {{ question.question }}
          </div>
         
        </li>
      </ul>
      <EditQuestion :show-modal="showEditModal" @close-modal="showEditModal = false" :question="selectedQuestion" @question-updated="getQuestions" />

        </div>
    </div>
</template>

<script>
  import AddQuestion from './modals/AddQuestion.vue'
  import EditQuestion from './modals/EditQuestion.vue';
  export default{
    components: {
        AddQuestion,
        EditQuestion
  },
    data() {
      return {
        showAddModal: false,
        showEditModal: false,
        questions: [],
        selectedQuestion: null,
      };
    },
    methods: {
      async  get_question(id){

        try {
          const response = await axios.get(`/get_question/${id}`);
          this.selectedQuestion = response.data.question;
          this.showEditModal = true;
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
      editQuestion(id) {
        this.get_question(id);
        
      },
      async getQuestions() {
        try {
          const response = await axios.get('/get_questions');
          if(response.data.questions){
            this.questions = response.data.questions;
          }

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
      }
    },
    created() {
      this.getQuestions();
    }

  }
</script>