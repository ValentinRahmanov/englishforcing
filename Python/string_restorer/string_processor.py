class StringProcessor:

    newstr = ""
    final_str = ""
    counter = 1
    newstr_arr = []

    def __init__(self, file_to_read, file_with_result):
        self.file_to_read = file_to_read
        self.file_with_result = file_with_result
 
    def read_string_from_input_file(self):
        file = open(self.file_to_read, 'r')
        self.string = file.readline().strip('\n')
        file.close()
   
    def culc_last_elem_index(self):
         self.fin_sign_in_str = len(self.string)

    def add_spaces_between_numbers_and_letters(self):
        
        for index, letter in enumerate(self.string):
            if index == 0:
                self.newstr += letter 
                continue

            if letter.isdigit() and self.string[index-1].isalpha():
                self.newstr += " " + letter
            elif letter.isalpha() and self.string[index-1].isdigit():
                self.newstr += " " + letter
            else:
                self.newstr += letter
    
    def replace_numbers_with_needed_letter_repeats(self):

        self.newstr_arr = self.newstr.split(" ")

        for ind, elem in enumerate(self.newstr_arr):
            if self.counter%2 != 0:
                self.final_str += elem * int(self.newstr_arr[ind + 1])
        
            self.counter += 1
           
    def write_the_result_in_output_file(self):
        with open(self.file_with_result, 'w', encoding='utf-8') as f:
            f.write(self.final_str)
