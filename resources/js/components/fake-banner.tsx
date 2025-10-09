type Props = {
    className: string;
    word: string;
};

export const FakeBanner = ({ className, word }: Props) => {
    return (
        <div className="flex items-center justify-center py-3">
            <div className={`w-2xl rounded-lg p-3 text-center ${className}`}>{word}</div>
        </div>
    );
};
