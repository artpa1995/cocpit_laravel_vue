import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';
export default function Helpers(){
    const store = useStore()
    // const route = useRoute()
    const router = useRouter()

    const logout = async() => {
        try{
            let response = await axios.post('/logout')
            store.dispatch('removeUser')
          
            router.push('/login')
        }
        catch(error){
            console.error('Server Error')
        }
    }
    return{
    logout
    }
}