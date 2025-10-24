import { motion } from "framer-motion";

/**
 * 🌿 FadePage
 * Wrapper d’animation pour chaque page admin
 * Applique un effet d’apparition fluide (fade + slide)
 */
export default function FadePage({ children }) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      exit={{ opacity: 0, y: -20 }}
      transition={{ duration: 0.5, ease: "easeOut" }}
      className="w-full h-full"
    >
      {children}
    </motion.div>
  );
}
