<template>
  <div>
    <div class="px-6 mt-5">
      <vue-good-table
        styleClass="vgt-table striped"
        :columns="columns"
        :rows="formattedRows"
        :search-options="{ enabled: true }"
        @cell-click="handleCellClick"
        :pagination-options="{
          enabled: true,
          mode: 'records',
          perPage: 5,
          position: 'bottom',
          perPageDropdown: [5, 10, 25, 50, 100],
          dropdownAllowAll: false,
          setCurrentPage: 1,
          nextLabel: 'next',
          prevLabel: 'prev',
          rowsPerPageLabel: 'Rows per page',
          ofLabel: 'of',
          pageLabel: 'page',
          allLabel: 'All',
          infoFn: (params) => `my own page ${params.firstRecordOnPage}`,
        }"
      />
    </div>

    <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Change Status</h3>
                <div class="mt-2">
                  <select v-model="selectedStatus" class="block w-full mt-1">
                    <option :value="1">Pending</option>
                    <option :value="2">Approved</option>
                    <option :value="3">Rejected</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="updateStatus" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
            <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { VueGoodTable } from 'vue-good-table-next';
import { format } from 'date-fns';

export default {
  components: {
    VueGoodTable,
  },
  data() {
    return {
      columns: [
        { label: 'First name', field: 'first_name' },
        { label: 'Last name', field: 'last_name' },
        { label: 'Email', field: 'email' },
        { label: 'Created On', field: 'created_at' },
        { 
          label: 'Status', 
          field: 'status',
          tdClass: 'cursor-pointer',
          sortable: false,
          hidden: true,
        },
        { 
          label: 'Status', 
          field: 'status_text',
          sortable: false,
        },
      ],
      rows: [],
      showModal: false,
      selectedStatus: 1,
      selectedUserId: null,
      statuses: {
        1: 'Pending',
        2: 'Approved',
        3: 'Rejected'
      }
    };
  },
  computed: {
    formattedRows() {
      return this.rows.map(row => {
        return {
          ...row,
          created_at: format(new Date(row.created_at), 'MM-dd-yyyy HH:mm:ss'),
          status_text: this.statuses[row.status] || 'Pending',
        };
      });
    }
  },
  methods: {
    handleCellClick(params) {
      if (params.column.field === 'status_text') {
        this.selectedUserId = params.row.id;
        this.selectedStatus = params.row.status;
        this.showModal = true;
      }
    },
    updateStatus() {
      if (this.selectedStatus) {
        this.showModal = false;
        axios.post('/update_user_status', {
          id: this.selectedUserId,
          status: this.selectedStatus,
        }).then(response => {
          alert('Status updated successfully:', response);
          this.selectedUserId = null;
          this.selectedStatus = null;
          this.fetchUsers();
        }).catch(error => {
          console.error('Error updating status:', error);
        });
      }
    },
    fetchUsers() {
      axios.post('/get_users', [], {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        if (response.data.users) {
          this.rows = response.data.users;
        }
      })
      .catch(error => {
        console.error('Error fetching users:', error);
      });
    }
  },
  created() {
    this.fetchUsers();
  }
};
</script>

<style scoped>
</style>
