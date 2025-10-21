import { motion } from "framer-motion";

export default function Toast({ message, onClose }) {
  return (
      <motion.div
            initial={{ opacity: 0, y: -30 }}
                  animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: -30 }}
                              transition={{ duration: 0.3 }}
                                    className="fixed top-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50"
                                        >
                                              <span>✅ {message}</span>
                                                    <button onClick={onClose} className="ml-3 text-sm opacity-80 hover:opacity-100">
                                                            ✖
                                                                  </button>
                                                                      </motion.div>
                                                                        );
                                                                        }
                                                                        
