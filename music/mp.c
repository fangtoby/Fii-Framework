struct ret_value
{
    char *data;
    unsigned long size;
    ret_value()
   {
       data = 0;
       size = 0;
   }
};
void load_wave_file(char *fname, struct ret_value *ret)
{
    FILE *fp;
    fp = fopen(fname,"rb");
    if (fp)
    {
        char id[5];          // 5个字节存储空间存储'RIFF'和'\0'，这个是为方便利用strcmp
        unsigned long size;  // 存储文件大小
　　        short format_tag, channels, block_align, bits_per_sample;    // 16位数据
　　        unsigned long format_length, sample_rate, avg_bytes_sec, data_size; // 32位数据
        fread(id, sizeof(char), 4, fp); // 读取'RIFF'
        id[4] = '\0';
  
        if (!strcmp(id, "RIFF"))
        { 
            fread(&size, sizeof(unsigned long), 1, fp); // 读取文件大小
            fread(id, sizeof(char), 4, fp);         // 读取'WAVE'
            id[4] = '\0';
            if (!strcmp(id,"WAVE"))
            { 
                fread(id, sizeof(char), 4, fp);     // 读取4字节 "fmt ";
                fread(&format_length, sizeof(unsigned long),1,fp);
                fread(&format_tag, sizeof(short), 1, fp); // 读取文件tag
                fread(&channels, sizeof(short),1,fp);    // 读取通道数目
                fread(&sample_rate, sizeof(unsigned long), 1, fp);   // 读取采样率大小
　　                fread(&avg_bytes_sec, sizeof(unsigned long), 1, fp); // 读取每秒数据量
　　                fread(&block_align, sizeof(short), 1, fp);     // 读取块对齐
                fread(&bits_per_sample, sizeof(short), 1, fp);       // 读取每一样本大小
                fread(id, sizeof(char), 4, fp);                      // 读入'data'
                fread(&data_size, sizeof(unsigned long), 1, fp);     // 读取数据大小
                ret->size = data_size;
                ret->data = (char *) malloc(sizeof(char)*data_size); // 申请内存空间
                fread(ret->data, sizeof(char), data_size, fp);       // 读取数据
            }
            else
           {
                printf("Error: RIFF file but not a wave file\n");
           }
        }
        else
       {
            printf("Error: not a RIFF file\n");
       }
    }
}