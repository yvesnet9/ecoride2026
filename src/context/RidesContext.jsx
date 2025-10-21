import { createContext, useContext, useState, useEffect } from "react";
import { rides as defaultRides } from "../data/rides";

const RidesContext = createContext();
export const useRides = () => useContext(RidesContext);

export const RidesProvider = ({ children }) => {
  const [rides, setRides] = useState([]);

    useEffect(() => {
        const stored = localStorage.getItem("ecorideRides");
            if (stored) setRides(JSON.parse(stored));
                else setRides(defaultRides);
                  }, []);

                    useEffect(() => {
                        localStorage.setItem("ecorideRides", JSON.stringify(rides));
                          }, [rides]);

                            const addRide = (ride) => {
                                const newRide = { ...ride, id: Date.now() };
                                    setRides([...rides, newRide]);
                                      };

                                        const deleteRide = (id) => {
                                            setRides(rides.filter((r) => r.id !== id));
                                              };

                                                return (
                                                    <RidesContext.Provider value={{ rides, addRide, deleteRide }}>
                                                          {children}
                                                              </RidesContext.Provider>
                                                                );
                                                                };
                                                                
