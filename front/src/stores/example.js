/**
 * ! Fichier de démonstration d'un ancien Store (Projet Coop Vue3)
 */

import { defineStore } from 'pinia'

export const useSessionStore = defineStore('session', () => {
  const data = reactive({
    member: {},
    token: ''
  })

  function setSession(m,t){
    data.member = m;
    data.token = t;
  }
  
  function emptySession(){
    data.member = {};
    data.token = '';
  }

  return { data, setSession, emptySession }
}, {
  persist: true,
})
