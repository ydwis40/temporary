import{d as c,T as f,c as w,w as d,o as _,a as e,u as o,Z as V,b as t,e as b,n as g,f as k}from"./app-09798076.js";import{_ as v}from"./GuestLayout.vue_vue_type_script_setup_true_lang-38725c92.js";import{_ as l,a as m}from"./InputLabel.vue_vue_type_script_setup_true_lang-e4a616c9.js";import{P}from"./PrimaryButton-d0855d8a.js";import{_ as i}from"./TextInput.vue_vue_type_script_setup_true_lang-c0667514.js";import"./ApplicationLogo-17c7a710.js";import"./_plugin-vue_export-helper-c27b6911.js";const y=["onSubmit"],x={class:"mt-4"},B={class:"mt-4"},C={class:"flex items-center justify-end mt-4"},j=c({__name:"ResetPassword",props:{email:{},token:{}},setup(p){const n=p,s=f({token:n.token,email:n.email,password:"",password_confirmation:""}),u=()=>{s.post(route("password.store"),{onFinish:()=>s.reset("password","password_confirmation")})};return($,a)=>(_(),w(v,null,{default:d(()=>[e(o(V),{title:"Reset Password"}),t("form",{onSubmit:k(u,["prevent"])},[t("div",null,[e(l,{for:"email",value:"Email"}),e(i,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:o(s).email,"onUpdate:modelValue":a[0]||(a[0]=r=>o(s).email=r),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),e(m,{class:"mt-2",message:o(s).errors.email},null,8,["message"])]),t("div",x,[e(l,{for:"password",value:"Password"}),e(i,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o(s).password,"onUpdate:modelValue":a[1]||(a[1]=r=>o(s).password=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),e(m,{class:"mt-2",message:o(s).errors.password},null,8,["message"])]),t("div",B,[e(l,{for:"password_confirmation",value:"Confirm Password"}),e(i,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:o(s).password_confirmation,"onUpdate:modelValue":a[2]||(a[2]=r=>o(s).password_confirmation=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),e(m,{class:"mt-2",message:o(s).errors.password_confirmation},null,8,["message"])]),t("div",C,[e(P,{class:g({"opacity-25":o(s).processing}),disabled:o(s).processing},{default:d(()=>[b(" Reset Password ")]),_:1},8,["class","disabled"])])],40,y)]),_:1}))}});export{j as default};