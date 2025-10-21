import { Routes, Route } from "react-router-dom";
import Home from "../pages/Home";
import Rides from "../pages/Rides";
import Contact from "../pages/Contact";
import Login from "../pages/Login";
import Mentions from "../pages/Mentions";
import RideDetail from "../pages/RideDetail";
import Register from "../pages/Register";
import Profile from "../pages/Profile";

export default function AppRouter() {
  return (
      <Routes>
            <Route path="/" element={<Home />} />
                  <Route path="/rides" element={<Rides />} />
                        <Route path="/rides/:id" element={<RideDetail />} />
                              <Route path="/contact" element={<Contact />} />
                                    <Route path="/login" element={<Login />} />
                                          <Route path="/register" element={<Register />} />
                                                <Route path="/profile" element={<Profile />} />
                                                      <Route path="/mentions" element={<Mentions />} />
                                                            <Route
                                                                    path="*"
                                                                            element={
                                                                                      <h1 className="text-center text-red-500 mt-10">
                                                                                                  404 - Page non trouvée
                                                                                                            </h1>
                                                                                                                    }
                                                                                                                          />
                                                                                                                              </Routes>
                                                                                                                                );
                                                                                                                                }
                                                                                                                                
