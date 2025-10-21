import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.jsx";
import { RidesProvider } from "./context/RidesContext.jsx";

createRoot(document.getElementById("root")).render(
  <StrictMode>
      <RidesProvider>
            <App />
                </RidesProvider>
                  </StrictMode>
                  );
                  
