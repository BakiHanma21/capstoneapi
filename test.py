import tkinter as tk
from tkinter import ttk
import hashlib
import base64

class HashDecoderGUI:
    def __init__(self, root):
        self.root = root
        self.root.title("Hash Decoder")
        self.root.geometry("600x400")

        # Input frame
        input_frame = ttk.LabelFrame(root, text="Input", padding="10")
        input_frame.pack(fill="x", padx=10, pady=5)

        ttk.Label(input_frame, text="Enter Hash:").pack()
        self.hash_input = ttk.Entry(input_frame, width=50)
        self.hash_input.pack(pady=5)

        # Hash type selection
        ttk.Label(input_frame, text="Select Hash Type:").pack()
        self.hash_type = ttk.Combobox(input_frame, 
                                     values=["MD5", "SHA1", "SHA256", "Base64"])
        self.hash_type.set("MD5")
        self.hash_type.pack(pady=5)

        # Decode button
        ttk.Button(input_frame, text="Decode", 
                  command=self.decode_hash).pack(pady=5)

        # Output frame
        output_frame = ttk.LabelFrame(root, text="Output", padding="10")
        output_frame.pack(fill="both", expand=True, padx=10, pady=5)

        self.output_text = tk.Text(output_frame, height=10)
        self.output_text.pack(fill="both", expand=True)

    def decode_hash(self):
        hash_input = self.hash_input.get()
        hash_type = self.hash_type.get()

        try:
            if hash_type == "Base64":
                decoded = base64.b64decode(hash_input).decode('utf-8')
                self.output_text.delete(1.0, tk.END)
                self.output_text.insert(tk.END, f"Decoded Base64: {decoded}")
            else:
                self.output_text.delete(1.0, tk.END)
                self.output_text.insert(tk.END, 
                    "Note: Hash functions are one-way functions.\n"
                    "They cannot be directly decoded.\n"
                    "You would need to use a rainbow table or brute force "
                    "to find the original value.")

        except Exception as e:
            self.output_text.delete(1.0, tk.END)
            self.output_text.insert(tk.END, f"Error: {str(e)}")

if __name__ == "__main__":
    root = tk.Tk()
    app = HashDecoderGUI(root)
    root.mainloop()
