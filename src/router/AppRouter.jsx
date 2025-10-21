import { Routes, Route } from "react-router-dom";
import Home from "../pages/Home.jsx";
import Rides from "../pages/Rides.jsx";
import Profile from "../pages/Profile.jsx";
import AdminDashboard from "../pages/AdminDashboard.jsx";
import ProtectedAdminRoute from "../components/ProtectedAdminRoute.jsx";
import ProfileRides from "../pages/ProfileRides.jsx";
import PassengerRides from "../pages/PassengerRides.jsx";
import Admin from "../pages/Admin.jsx";
import Contact from "../pages/Contact.jsx";
import Login from "../pages/Login.jsx";
import Register from "../pages/Register.jsx";
import Mentions from "../pages/Mentions.jsx";
import RideDetail from "../pages/RideDetail.jsx";

export default function AppRouter() {
  return (
      <Routes>
            {/* --- Pages publiques --- */}
                  <Route path="/" element={<Home />} />
                        <Route path="/rides" element={<Rides />} />
                              <Route path="/rides/:id" element={<RideDetail />} />
                                    <Route path="/contact" element={<Contact />} />
                                          <Route path="/mentions" element={<Mentions />} />
                                                <Route path="/login" element={<Login />} />
                                                      <Route path="/register" element={<Register />} />

                                                            {/* --- Espace utilisateur --- */}
                                                                  <Route path="/profile" element={<Profile />} />
                                                                        <Route path="/profile/rides" element={<ProfileRides />} />
                                                                              <Route path="/profile/passenger" element={<PassengerRides />} />

                                                                                    {/* --- Espace admin --- */}
                                                                                          <Route path="/admin" element={<Admin />} />
                                                                                                <Route
                                                                                                        path="/admin/dashboard"
                                                                                                                element={
                                                                                                                          <ProtectedAdminRoute>
                                                                                                                                      <AdminDashboard />
                                                                                                                                                </ProtectedAdminRoute>
                                                                                                                                                        }
                                                                                                                                                              />
                                                                                                                                                                  </Routes>
                                                                                                                                                                    );
                                                                                                                                                                    }
                                                                                                                                                                    
