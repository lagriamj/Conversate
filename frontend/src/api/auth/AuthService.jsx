// src/services/authService.js

import api from "../axios";

const login = async (email, password) => {
  console.log("email: ", email);
  console.log("password", password);
  const response = await api.post("/login", { email, password });
  console.log("response from auth service: ", response);
  return response.data;
};

const logout = async () => {
  await api.post("/logout");
};

const getCurrentUser = () => {
  return JSON.parse(localStorage.getItem("user"));
};

export default {
  login,
  logout,
  getCurrentUser,
};
